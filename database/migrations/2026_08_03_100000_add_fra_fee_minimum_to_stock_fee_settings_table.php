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
            $table->double('fra_fee_minimum')->nullable()->default(1)->after('fra_fee_percentage');
        });

        DB::table('stock_fee_settings')->whereNull('fra_fee_minimum')->update(['fra_fee_minimum' => 1]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('stock_fee_settings', function (Blueprint $table) {
            $table->dropColumn('fra_fee_minimum');
        });
    }
};
