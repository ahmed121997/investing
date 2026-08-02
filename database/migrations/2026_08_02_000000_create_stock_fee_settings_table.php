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
        Schema::create('stock_fee_settings', function (Blueprint $table) {
            $table->id();
            $table->double('thunder_percentage')->nullable();
            $table->double('thunder_fixed_fee')->nullable();
            $table->double('exchange_fee_percentage')->nullable();
            $table->double('egx_fee_percentage')->nullable();
            $table->double('misr_clearing_fee_percentage')->nullable();
            $table->double('fra_fee_percentage')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stock_fee_settings');
    }
};
