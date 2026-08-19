<?php

namespace App\Services;

use App\Models\Order;
use App\Models\Setting;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class UpsService
{
    protected string $baseUrl;

    public function __construct()
    {
        // Use sandbox for testing, production for live
        $isSandbox = config('services.ups.sandbox', true);
        $this->baseUrl = $isSandbox
            ? 'https://wwwcie.ups.com/api'
            : 'https://onlinetools.ups.com/api';
    }

    /**
     * Get OAuth2 Bearer token from UPS.
     */
    protected function getToken(): string
    {
        $clientId     = config('services.ups.client_id');
        $clientSecret = config('services.ups.client_secret');

        if (empty($clientId) || empty($clientSecret)) {
            throw new \Exception('UPS Client ID and Client Secret are not configured. Please add them in Admin → Settings.');
        }

        $response = Http::withBasicAuth($clientId, $clientSecret)
            ->asForm()
            ->post("{$this->baseUrl}/security/v1/oauth/token", [
                'grant_type' => 'client_credentials',
            ]);

        if ($response->successful()) {
            return $response->json('access_token');
        }

        Log::error('UPS OAuth Failed: ' . $response->body());
        throw new \Exception('UPS authentication failed: ' . ($response->json('response.errors.0.message') ?? $response->body()));
    }

    /**
     * Map UPS service names to service codes.
     */
    public static function serviceCodes(): array
    {
        return [
            'UPS Ground'          => '03',
            'UPS 3 Day Select'    => '12',
            'UPS 2nd Day Air'     => '02',
            'UPS Next Day Air'    => '01',
            'UPS Next Day Air Saver' => '13',
        ];
    }

    /**
     * Create a UPS shipment for an order.
     */
    public function createShipment(Order $order, string $serviceCode = '03'): array
    {
        $token    = $this->getToken();
        $settings = Setting::pluck('value', 'key')->all();

        // Shipper info from settings (your store)
        $shipperName    = $settings['site_name'] ?? 'Pepperlemon';
        $shipperPhone   = $settings['site_phone'] ?? '';
        $shipperAddress = $settings['ups_ship_from_address'] ?? '12800 Northborough Dr';
        $shipperCity    = $settings['ups_ship_from_city'] ?? 'Houston';
        $shipperState   = $settings['ups_ship_from_state'] ?? 'TX';
        $shipperZip     = $settings['ups_ship_from_zip'] ?? '77067';
        $shipperAccount = config('services.ups.account_number', $settings['ups_account_number'] ?? '');

        // Calculate total weight (lbs) from order items
        $totalWeightLbs = 0;
        foreach ($order->items as $item) {
            $product = $item->product;
            // Weight stored in lbs; default 0.5 lb per item if not set
            $unitWeight = $product && $product->weight ? (float) $product->weight : 0.5;
            $totalWeightLbs += $unitWeight * $item->quantity;
        }
        $totalWeightLbs = max(0.1, $totalWeightLbs);

        // Split recipient name
        $nameParts = explode(' ', trim($order->shipping_name), 2);
        $firstName = $nameParts[0];
        $lastName  = $nameParts[1] ?? 'Customer';

        $payload = [
            'ShipmentRequest' => [
                'Shipment' => [
                    'Description' => 'Pepperlemon Order #' . $order->order_number,
                    'Shipper' => [
                        'Name'                => $shipperName,
                        'AttentionName'       => $shipperName,
                        'Phone'               => ['Number' => preg_replace('/\D/', '', $shipperPhone)],
                        'ShipperNumber'       => $shipperAccount,
                        'Address' => [
                            'AddressLine'       => [$shipperAddress],
                            'City'              => $shipperCity,
                            'StateProvinceCode' => $shipperState,
                            'PostalCode'        => $shipperZip,
                            'CountryCode'       => 'US',
                        ],
                    ],
                    'ShipTo' => [
                        'Name'          => $firstName . ' ' . $lastName,
                        'AttentionName' => $order->shipping_name,
                        'Phone'         => ['Number' => preg_replace('/\D/', '', $order->shipping_phone)],
                        'Address' => [
                            'AddressLine'       => [$order->shipping_address],
                            'City'              => $order->shipping_city,
                            'StateProvinceCode' => $order->shipping_state,
                            'PostalCode'        => $order->shipping_zip,
                            'CountryCode'       => 'US',
                            'ResidentialAddressIndicator' => '',
                        ],
                    ],
                    'ShipFrom' => [
                        'Name'          => $shipperName,
                        'AttentionName' => $shipperName,
                        'Phone'         => ['Number' => preg_replace('/\D/', '', $shipperPhone)],
                        'Address' => [
                            'AddressLine'       => [$shipperAddress],
                            'City'              => $shipperCity,
                            'StateProvinceCode' => $shipperState,
                            'PostalCode'        => $shipperZip,
                            'CountryCode'       => 'US',
                        ],
                    ],
                    'Service' => [
                        'Code'        => $serviceCode,
                        'Description' => array_search($serviceCode, self::serviceCodes()) ?: 'UPS Ground',
                    ],
                    'Package' => [
                        [
                            'Description'    => 'Pepperlemon Package',
                            'Packaging'      => ['Code' => '02', 'Description' => 'Customer Supplied Package'],
                            'PackageWeight'  => [
                                'UnitOfMeasurement' => ['Code' => 'LBS', 'Description' => 'Pounds'],
                                'Weight'            => (string) round($totalWeightLbs, 1),
                            ],
                            'ReferenceNumber' => [
                                'Code'  => 'PO',
                                'Value' => $order->order_number,
                            ],
                        ],
                    ],
                    'PaymentInformation' => [
                        'ShipmentCharge' => [
                            'Type'   => '01', // Transportation
                            'BillShipper' => ['AccountNumber' => $shipperAccount],
                        ],
                    ],
                ],
                'LabelSpecification' => [
                    'LabelImageFormat' => ['Code' => 'GIF', 'Description' => 'GIF'],
                    'HTTPUserAgent'    => 'Mozilla/4.5',
                ],
            ],
        ];

        Log::info('UPS Shipment Payload for order ' . $order->order_number);

        $response = Http::withToken($token)
            ->withHeaders(['transId' => $order->order_number, 'transactionSrc' => 'Pepperlemon'])
            ->post("{$this->baseUrl}/shipments/v1/ship", $payload);

        if ($response->successful()) {
            $data            = $response->json('ShipmentResponse.ShipmentResults');
            $trackingNumber  = $data['PackageResults']['TrackingNumber'] ?? null;
            $shipmentIdNo    = $data['ShipmentIdentificationNumber'] ?? null;

            $order->update([
                'ups_tracking_number' => $trackingNumber,
                'ups_shipment_id'     => $shipmentIdNo,
                'ups_status'          => 'Label Created',
                'ups_service_code'    => $serviceCode,
                'status'              => 'shipped',
            ]);

            Log::info("UPS Shipment created for order {$order->order_number}: tracking={$trackingNumber}");

            return [
                'success'         => true,
                'tracking_number' => $trackingNumber,
                'shipment_id'     => $shipmentIdNo,
            ];
        }

        $errorMsg = $response->json('response.errors.0.message')
            ?? $response->json('Fault.detail.Errors.ErrorDetail.PrimaryErrorCode.Description')
            ?? 'Unknown UPS Error';

        Log::error('UPS Shipment Failed for order ' . $order->order_number . ': ' . $response->body());
        throw new \Exception($errorMsg);
    }

    /**
     * Track a UPS shipment by tracking number.
     */
    public function trackShipment(string $trackingNumber): array
    {
        $token = $this->getToken();

        $response = Http::withToken($token)
            ->withHeaders(['transId' => $trackingNumber, 'transactionSrc' => 'Pepperlemon'])
            ->get("{$this->baseUrl}/track/v1/details/{$trackingNumber}", [
                'locale'         => 'en_US',
                'returnSignature' => 'false',
            ]);

        if ($response->successful()) {
            return $response->json();
        }

        throw new \Exception('UPS Tracking failed: ' . ($response->json('response.errors.0.message') ?? 'Unknown error'));
    }
}
