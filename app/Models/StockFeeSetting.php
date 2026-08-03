<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StockFeeSetting extends Model
{
    protected $fillable = [
        'thunder_percentage',
        'thunder_fixed_fee',
        'exchange_fee_percentage',
        'risk_fund_fee_percentage',
        'misr_clearing_fee_percentage',
        'fra_fee_percentage',
        'fra_fee_minimum',
        'tax_t0_percentage',
        'tax_t1_t2_percentage',
    ];

    protected $casts = [
        'thunder_percentage' => 'float',
        'thunder_fixed_fee' => 'float',
        'exchange_fee_percentage' => 'float',
        'risk_fund_fee_percentage' => 'float',
        'misr_clearing_fee_percentage' => 'float',
        'fra_fee_percentage' => 'float',
        'fra_fee_minimum' => 'float',
        'tax_t0_percentage' => 'float',
        'tax_t1_t2_percentage' => 'float',
    ];

    /**
     * Default application-wide fee configuration.
     *
     * @return array<string, float>
     */
    public static function defaults(): array
    {
        return [
            'thunder_fixed_fee' => 2,
            'thunder_percentage' => 0.1,
            'exchange_fee_percentage' => 0.01,
            'risk_fund_fee_percentage' => 0.01,
            'misr_clearing_fee_percentage' => 0.005,
            'fra_fee_percentage' => 0.005,
            'fra_fee_minimum' => 1,
            'tax_t0_percentage' => 0.025,
            'tax_t1_t2_percentage' => 0.05,
        ];
    }

    /**
     * The settings columns that make up the configurable fee set.
     *
     * @return array<int, string>
     */
    public static function defaultsFields(): array
    {
        return array_keys(static::defaults());
    }

    public static function current(): self
    {
        return static::query()->firstOrCreate(['id' => 1], static::defaults());
    }
}
