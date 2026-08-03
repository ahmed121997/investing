<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('stock_fee_settings', function (Blueprint $table) {
            $table->double('tax_t0_percentage')->nullable()->default(0.025)->after('fra_fee_percentage');
            $table->double('tax_t1_t2_percentage')->nullable()->default(0.05)->after('tax_t0_percentage');
        });

        DB::table('stock_fee_settings')->whereNull('tax_t0_percentage')->update(['tax_t0_percentage' => 0.025]);
        DB::table('stock_fee_settings')->whereNull('tax_t1_t2_percentage')->update(['tax_t1_t2_percentage' => 0.05]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('stock_fee_settings', function (Blueprint $table) {
            $table->dropColumn(['tax_t0_percentage', 'tax_t1_t2_percentage']);
        });
    }
};
