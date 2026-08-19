<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            // Add UPS columns
            $table->string('ups_tracking_number')->nullable()->after('stripe_client_secret');
            $table->string('ups_shipment_id')->nullable()->after('ups_tracking_number');
            $table->string('ups_status')->nullable()->after('ups_shipment_id');
            $table->string('ups_service_code')->nullable()->after('ups_status'); // e.g. "03" = UPS Ground

            // Drop Shiprocket columns if they exist
            foreach (['shiprocket_order_id', 'shiprocket_shipment_id', 'shiprocket_awb_code', 'shiprocket_status'] as $col) {
                if (Schema::hasColumn('orders', $col)) {
                    $table->dropColumn($col);
                }
            }
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['ups_tracking_number', 'ups_shipment_id', 'ups_status', 'ups_service_code']);
            $table->string('shiprocket_order_id')->nullable();
            $table->string('shiprocket_shipment_id')->nullable();
            $table->string('shiprocket_awb_code')->nullable();
            $table->string('shiprocket_status')->nullable();
        });
    }
};
