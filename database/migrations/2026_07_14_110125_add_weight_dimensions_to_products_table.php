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
        Schema::table('products', function (Blueprint $table) {
            $table->decimal('weight', 6, 3)->default(0.200)->after('images')->comment('Packed weight in KG');
            $table->integer('length')->default(12)->after('weight')->comment('Box length in cm');
            $table->integer('width')->default(12)->after('length')->comment('Box width in cm');
            $table->integer('height')->default(12)->after('width')->comment('Box height in cm');
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['weight', 'length', 'width', 'height']);
        });
    }
};
