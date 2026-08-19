<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            // Add Stripe columns
            $table->string('stripe_payment_intent_id')->nullable()->after('payment_method');
            $table->string('stripe_client_secret')->nullable()->after('stripe_payment_intent_id');

            // Drop Razorpay columns if they exist
            if (Schema::hasColumn('orders', 'razorpay_order_id')) {
                $table->dropColumn('razorpay_order_id');
            }
            if (Schema::hasColumn('orders', 'razorpay_payment_id')) {
                $table->dropColumn('razorpay_payment_id');
            }
            if (Schema::hasColumn('orders', 'razorpay_signature')) {
                $table->dropColumn('razorpay_signature');
            }
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['stripe_payment_intent_id', 'stripe_client_secret']);
            $table->string('razorpay_order_id')->nullable()->after('payment_method');
            $table->string('razorpay_payment_id')->nullable()->after('razorpay_order_id');
            $table->string('razorpay_signature')->nullable()->after('razorpay_payment_id');
        });
    }
};
