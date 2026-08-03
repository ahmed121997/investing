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
            $table->double('thunder_percentage')->nullable()->default(0.1);
            $table->double('thunder_fixed_fee')->nullable()->default(2);
            $table->double('exchange_fee_percentage')->nullable()->default(0.01);
            $table->double('risk_fund_fee_percentage')->nullable()->default(0.01);
            $table->double('misr_clearing_fee_percentage')->nullable()->default(0.005);
            $table->double('fra_fee_percentage')->nullable()->default(0.005);
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
