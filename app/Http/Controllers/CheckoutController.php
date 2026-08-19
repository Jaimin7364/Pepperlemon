<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Stripe\Stripe;
use Stripe\PaymentIntent;
use Stripe\Webhook;
use Stripe\Exception\SignatureVerificationException;

class CheckoutController extends Controller
{
    // Show Checkout Form
    public function index()
    {
        if (auth()->user() && auth()->user()->is_admin) {
            return redirect()->route('cart.index')->with('error', 'Admins are not allowed to place orders.');
        }

        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->route('cart.index')->with('warning', 'Your cart is empty! Please add products before checking out.');
        }

        $subtotal = 0;
        foreach ($cart as $item) {
            $subtotal += $item['price'] * $item['quantity'];
        }

        return view('frontend.checkout', compact('cart', 'subtotal'));
    }

    // Place Order
    public function store(Request $request)
    {
        if (auth()->user() && auth()->user()->is_admin) {
            return redirect()->route('cart.index')->with('error', 'Admins are not allowed to place orders.');
        }

        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        // Validate stock availability for all cart items
        foreach ($cart as $productId => $item) {
            $product = Product::find($productId);
            if (!$product || $product->quantity < $item['quantity']) {
                $available = $product ? $product->quantity : 0;
                return redirect()->route('cart.index')->with('error', "Cannot complete order: '{$item['name']}' only has {$available} unit(s) left in stock.");
            }
        }

        // Validate basic info
        $validated = $request->validate([
            'shipping_name'    => 'required|string|max:255',
            'shipping_email'   => 'required|email|max:255',
            'shipping_phone'   => 'required|string|max:20',
            'delivery_type'    => 'required|string|in:online_delivery,self_pickup',
            'payment_method'   => 'required|string|in:cod,stripe',
            'notes'            => 'nullable|string',
        ]);

        $selectedAddressId = $request->input('selected_address_id');
        $drivingLicensePath = null;
        $salesTaxPermitPath = null;

        if ($validated['delivery_type'] === 'self_pickup') {
            $shippingAddress  = \App\Models\Setting::get('ups_ship_from_address', '12800 Northborough Dr');
            $shippingAddress2 = '';
            $shippingCity     = \App\Models\Setting::get('ups_ship_from_city', 'Houston');
            $shippingState    = \App\Models\Setting::get('ups_ship_from_state', 'TX');
            $shippingZip      = \App\Models\Setting::get('ups_ship_from_zip', '77067');
        } else {
            // Check if user selected a saved address
            if (auth()->check() && $selectedAddressId && $selectedAddressId !== 'new') {
                $savedAddress = auth()->user()->addresses()->find($selectedAddressId);
                if ($savedAddress) {
                    $shippingAddress    = $savedAddress->address;
                    $shippingAddress2   = $savedAddress->address2;
                    $shippingCity       = $savedAddress->city;
                    $shippingState      = $savedAddress->state;
                    $shippingZip        = $savedAddress->zip;
                    $drivingLicensePath = $savedAddress->driving_license;
                    $salesTaxPermitPath = $savedAddress->sales_tax_permit;
                } else {
                    abort(400, 'Invalid address selection.');
                }
            } else {
                // Validate address details if online delivery
                $rules = [
                    'shipping_address'  => 'required|string',
                    'shipping_address2' => 'nullable|string',
                    'shipping_city'     => 'required|string|max:100',
                    'shipping_state'    => 'required|string|max:100',
                    'shipping_zip'      => 'required|string|max:10',
                ];

                if (auth()->check()) {
                    $rules['driving_license'] = 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120';
                    $rules['sales_tax_permit'] = 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120';
                }

                $addressValidated = $request->validate($rules);

                $shippingAddress  = $addressValidated['shipping_address'];
                $shippingAddress2 = $addressValidated['shipping_address2'] ?? '';
                $shippingCity     = $addressValidated['shipping_city'];
                $shippingState    = $addressValidated['shipping_state'];
                $shippingZip      = $addressValidated['shipping_zip'];

                if (auth()->check()) {
                    if ($request->hasFile('driving_license')) {
                        $file = $request->file('driving_license');
                        $filename = time() . '_dl_' . $file->getClientOriginalName();
                        $file->move(public_path('uploads/documents'), $filename);
                        $drivingLicensePath = 'uploads/documents/' . $filename;
                    }

                    if ($request->hasFile('sales_tax_permit')) {
                        $file = $request->file('sales_tax_permit');
                        $filename = time() . '_st_' . $file->getClientOriginalName();
                        $file->move(public_path('uploads/documents'), $filename);
                        $salesTaxPermitPath = 'uploads/documents/' . $filename;
                    }

                    // Save as a new saved address for the user
                    $isFirst = auth()->user()->addresses()->count() === 0;
                    $newAddr = auth()->user()->addresses()->create([
                        'phone' => $validated['shipping_phone'],
                        'address' => $shippingAddress,
                        'address2' => $shippingAddress2,
                        'city' => $shippingCity,
                        'state' => $shippingState,
                        'zip' => $shippingZip,
                        'driving_license' => $drivingLicensePath,
                        'sales_tax_permit' => $salesTaxPermitPath,
                        'is_default' => $isFirst || $request->has('is_default'),
                    ]);

                    if ($newAddr->is_default) {
                        auth()->user()->addresses()->where('id', '!=', $newAddr->id)->update(['is_default' => false]);
                    }
                }
            }
        }

        // Merge address lines for legacy fields
        $fullAddress = trim($shippingAddress . ($shippingAddress2 ? ', ' . $shippingAddress2 : ''));

        // Auto-save user profile address if logged in and it's online delivery
        if (auth()->check() && $validated['delivery_type'] === 'online_delivery') {
            auth()->user()->update([
                'phone'   => $validated['shipping_phone'],
                'address' => $fullAddress,
                'city'    => $shippingCity,
                'state'   => $shippingState,
                'zip'     => $shippingZip,
            ]);
        }

        $subtotal = 0;
        foreach ($cart as $item) {
            $subtotal += $item['price'] * $item['quantity'];
        }

        $orderNumber = 'ORD-' . date('Ymd') . '-' . strtoupper(Str::random(4));

        // Create Order
        $order = Order::create([
            'user_id'          => auth()->id(),
            'order_number'     => $orderNumber,
            'total_amount'     => $subtotal,
            'status'           => 'pending',
            'payment_status'   => 'pending',
            'payment_method'   => $validated['payment_method'],
            'delivery_type'    => $validated['delivery_type'],
            'notes'            => $validated['notes'] ?? null,
            'shipping_name'    => $validated['shipping_name'],
            'shipping_email'   => $validated['shipping_email'],
            'shipping_phone'   => $validated['shipping_phone'],
            'shipping_address' => $fullAddress,
            'shipping_city'    => $shippingCity,
            'shipping_state'   => $shippingState,
            'shipping_zip'     => $shippingZip,
            'driving_license'  => $drivingLicensePath,
            'sales_tax_permit' => $salesTaxPermitPath,
        ]);

        // Create Order Items and decrement stock
        foreach ($cart as $productId => $item) {
            $product = Product::find($productId);
            if ($product) {
                $product->decrement('quantity', $item['quantity']);
            }
            OrderItem::create([
                'order_id'     => $order->id,
                'product_id'   => $productId,
                'product_name' => $item['name'],
                'quantity'     => $item['quantity'],
                'unit_price'   => $item['price'],
                'total_price'  => $item['price'] * $item['quantity'],
            ]);
        }

        // --- STRIPE PAYMENT ---
        if ($validated['payment_method'] === 'stripe') {
            try {
                Stripe::setApiKey(config('services.stripe.secret'));

                $paymentIntent = PaymentIntent::create([
                    'amount'      => (int) round($subtotal * 100), // cents
                    'currency'    => 'usd',
                    'description' => 'Pepperlemon Order #' . $order->order_number,
                    'metadata'    => [
                        'order_id'     => $order->id,
                        'order_number' => $order->order_number,
                    ],
                    'automatic_payment_methods' => ['enabled' => true],
                ]);

                $order->update([
                    'stripe_payment_intent_id' => $paymentIntent->id,
                    'stripe_client_secret'     => $paymentIntent->client_secret,
                ]);

                return view('frontend.stripe_payment', [
                    'order'           => $order,
                    'clientSecret'    => $paymentIntent->client_secret,
                    'stripePublicKey' => config('services.stripe.key'),
                ]);

            } catch (\Exception $e) {
                $order->update([
                    'status' => 'failed',
                    'notes'  => 'Stripe PaymentIntent creation failed: ' . $e->getMessage(),
                ]);
                return redirect()->route('checkout.index')->with('error', 'Unable to initiate payment: ' . $e->getMessage());
            }
        }

        // --- COD FLOW ---
        session()->forget('cart');
        return redirect()->route('checkout.success', ['order_number' => $order->order_number])
            ->with('success', 'Thank you! Your order has been placed successfully.');
    }

    // Handle Stripe payment success callback (return_url)
    public function handleStripeCallback(Request $request)
    {
        $paymentIntentId = $request->query('payment_intent');
        $redirectStatus  = $request->query('redirect_status');

        if (!$paymentIntentId) {
            return redirect()->route('checkout.index')->with('error', 'Invalid payment response.');
        }

        $order = Order::where('stripe_payment_intent_id', $paymentIntentId)->first();

        if (!$order) {
            return redirect()->route('checkout.index')->with('error', 'Order not found.');
        }

        if ($redirectStatus === 'succeeded') {
            $order->update([
                'payment_status' => 'completed',
                'status'         => 'processing',
            ]);

            session()->forget('cart');

            return redirect()->route('checkout.success', ['order_number' => $order->order_number])
                ->with('success', 'Payment successful! Your order has been placed.');
        }

        // Payment failed/cancelled — restore cart and cancel order
        $this->restoreCartAndCancelOrder($order, 'Payment failed or was cancelled.');

        return redirect()->route('checkout.index')->with('error', 'Payment was not completed. Your cart has been restored.');
    }

    // Cancel payment — restore cart
    public function cancelStripePayment(Request $request)
    {
        $orderId = $request->query('order_id');
        if ($orderId) {
            $order = Order::where('id', $orderId)->where('payment_status', 'pending')->with('items.product')->first();
            if ($order) {
                $this->restoreCartAndCancelOrder($order, 'Payment cancelled by user.');
            }
        }

        return redirect()->route('checkout.index')->with('warning', 'Payment was cancelled. Your cart has been restored — please try again.');
    }

    // Stripe Webhook — server-to-server event
    public function stripeWebhook(Request $request)
    {
        $payload   = $request->getContent();
        $sigHeader = $request->header('Stripe-Signature');
        $secret    = config('services.stripe.webhook_secret');

        try {
            $event = Webhook::constructEvent($payload, $sigHeader, $secret);
        } catch (SignatureVerificationException $e) {
            Log::warning('Stripe Webhook: Invalid signature — ' . $e->getMessage());
            return response()->json(['error' => 'Invalid signature'], 400);
        } catch (\Exception $e) {
            Log::warning('Stripe Webhook: Parse error — ' . $e->getMessage());
            return response()->json(['error' => 'Webhook error'], 400);
        }

        Log::info('Stripe Webhook received: ' . $event->type);

        if ($event->type === 'payment_intent.succeeded') {
            $intent = $event->data->object;
            $order  = Order::where('stripe_payment_intent_id', $intent->id)->first();
            if ($order && $order->payment_status !== 'completed') {
                $order->update([
                    'payment_status' => 'completed',
                    'status'         => 'processing',
                ]);
                Log::info('Stripe Webhook: Order ' . $order->order_number . ' marked completed.');
            }
        }

        if ($event->type === 'payment_intent.payment_failed') {
            $intent = $event->data->object;
            $order  = Order::where('stripe_payment_intent_id', $intent->id)->first();
            if ($order && $order->payment_status === 'pending') {
                $order->update([
                    'payment_status' => 'failed',
                    'status'         => 'failed',
                    'notes'          => 'Stripe payment failed via webhook.',
                ]);
            }
        }

        return response()->json(['status' => 'ok'], 200);
    }

    // Order Success page
    public function success($order_number)
    {
        $query = Order::where('order_number', $order_number)->with('items');
        if (auth()->check()) {
            $query->where('user_id', auth()->id());
        }
        $order = $query->firstOrFail();
        return view('frontend.order_success', compact('order'));
    }

    // Helper: restore session cart from order items and cancel the order
    private function restoreCartAndCancelOrder(Order $order, string $reason = ''): void
    {
        $cart = session()->get('cart', []);
        foreach ($order->items as $item) {
            $cart[$item->product_id] = [
                'name'     => $item->product_name,
                'price'    => $item->unit_price,
                'quantity' => $item->quantity,
                'image'    => $item->product ? $item->product->primary_image_url : asset('images/logo.jpeg'),
            ];
            // Restore stock
            if ($item->product) {
                $item->product->increment('quantity', $item->quantity);
            }
        }
        session()->put('cart', $cart);

        $order->update([
            'status'         => 'cancelled',
            'payment_status' => 'failed',
            'notes'          => $reason,
        ]);
    }
}
