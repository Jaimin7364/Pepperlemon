<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->string('shipping_name')->after('user_id')->nullable();
            $table->string('shipping_email')->after('shipping_name')->nullable();
            $table->string('shipping_phone')->after('shipping_email')->nullable();
            $table->text('shipping_address')->after('shipping_phone')->nullable();
            $table->string('shipping_city')->after('shipping_address')->nullable();
            $table->string('shipping_state')->after('shipping_city')->nullable();
            $table->string('shipping_zip')->after('shipping_state')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn([
                'shipping_name',
                'shipping_email',
                'shipping_phone',
                'shipping_address',
                'shipping_city',
                'shipping_state',
                'shipping_zip'
            ]);
        });
    }
};
