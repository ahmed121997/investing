<?php

namespace App\Models;

use App\Enums\FinancialPeriodType;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FinancialReport extends Model
{
    protected $fillable = [
        'stock_id', 'period_a_type', 'period_a_year', 'period_a_month', 'period_a_title',
        'period_b_type', 'period_b_year', 'period_b_month', 'period_b_title',
        'revenue_a', 'revenue_b', 'gross_profit_a', 'gross_profit_b', 'net_profit_a', 'net_profit_b', 'eps_a', 'eps_b',
        'revenue_note', 'gross_profit_note', 'net_profit_note', 'eps_note', 'summary_notes',
        'enable_projection', 'projection_multiplier', 'operating_profit', 'operating_margin', 'net_margin', 'book_value',
        'cash_balance', 'total_assets', 'total_liabilities', 'shareholders_equity', 'created_by', 'updated_by',
    ];

    protected function casts(): array
    {
        return [
            'period_a_type' => FinancialPeriodType::class,
            'period_b_type' => FinancialPeriodType::class,
            'enable_projection' => 'boolean',
            'projection_multiplier' => 'decimal:2',
        ];
    }

    public function stock(): BelongsTo { return $this->belongsTo(Stock::class); }
    public function creator(): BelongsTo { return $this->belongsTo(User::class, 'created_by'); }
    public function updater(): BelongsTo { return $this->belongsTo(User::class, 'updated_by'); }

    public function coverage(string $metric): ?float
    {
        $base = (float) $this->getAttribute("{$metric}_b");
        $current = (float) $this->getAttribute("{$metric}_a");
        return $base == 0.0 ? null : round(($current / $base) * 100, 2);
    }

    public function projected(string $metric): ?float
    {
        if (! $this->enable_projection || $this->getAttribute("{$metric}_a") === null) return null;
        return round((float) $this->getAttribute("{$metric}_a") * (float) $this->projection_multiplier, 6);
    }

    public function getNetProfitGrowthAttribute(): ?float { return $this->coverage('net_profit'); }
    public function getEpsGrowthAttribute(): ?float { return $this->coverage('eps'); }

    public function scopeLatestPerStock(Builder $query): Builder
    {
        return $query->latest('created_at');
    }
}
