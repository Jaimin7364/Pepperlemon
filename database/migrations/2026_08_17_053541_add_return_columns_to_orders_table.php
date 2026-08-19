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
            $table->string('return_reason')->nullable()->after('ups_service_code');
            $table->text('return_comments')->nullable()->after('return_reason');
            $table->string('return_status')->nullable()->after('return_comments'); // pending, approved, rejected
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['return_reason', 'return_comments', 'return_status']);
        });
    }
};
