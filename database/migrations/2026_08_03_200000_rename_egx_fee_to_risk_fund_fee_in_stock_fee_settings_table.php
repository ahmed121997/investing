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
        Schema::table('stock_fee_settings', function (Blueprint $table) {
            $table->renameColumn('egx_fee_percentage', 'risk_fund_fee_percentage');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('stock_fee_settings', function (Blueprint $table) {
            $table->renameColumn('risk_fund_fee_percentage', 'egx_fee_percentage');
        });
    }
};
