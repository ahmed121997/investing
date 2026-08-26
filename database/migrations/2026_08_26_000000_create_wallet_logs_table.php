<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('wallet_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('wallet_id')->constrained()->cascadeOnDelete();
            $table->unsignedBigInteger('trade_track_id')->nullable()->index();
            $table->unsignedBigInteger('trade_id')->nullable()->index();
            $table->string('action');
            $table->string('transaction_type')->nullable();
            $table->decimal('amount', 15, 2);
            $table->decimal('cash_change', 15, 2);
            $table->decimal('cash_before', 15, 2);
            $table->decimal('cash_after', 15, 2);
            $table->decimal('save_cloud_before', 15, 2)->nullable();
            $table->decimal('save_cloud_after', 15, 2)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('wallet_logs');
    }
};
