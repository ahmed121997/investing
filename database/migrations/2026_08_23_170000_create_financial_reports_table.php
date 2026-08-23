<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('financial_reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('stock_id')->constrained()->cascadeOnDelete();
            foreach (['a', 'b'] as $period) {
                $table->string("period_{$period}_type");
                $table->unsignedSmallInteger("period_{$period}_year")->nullable();
                $table->unsignedTinyInteger("period_{$period}_month")->nullable();
                $table->string("period_{$period}_title");
            }
            foreach (['revenue', 'gross_profit', 'net_profit', 'eps'] as $metric) {
                $table->decimal("{$metric}_a", 20, 6)->nullable();
                $table->decimal("{$metric}_b", 20, 6)->nullable();
                $table->text("{$metric}_note")->nullable();
            }
            $table->longText('summary_notes')->nullable();
            $table->boolean('enable_projection')->default(false);
            $table->decimal('projection_multiplier', 8, 2)->default(2);
            foreach (['operating_profit', 'operating_margin', 'net_margin', 'book_value', 'cash_balance', 'total_assets', 'total_liabilities', 'shareholders_equity'] as $metric) {
                $table->decimal($metric, 20, 6)->nullable();
            }
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('financial_reports');
    }
};
