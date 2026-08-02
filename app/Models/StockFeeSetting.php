<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StockFeeSetting extends Model
{
    protected $fillable = [
        'thunder_percentage',
        'thunder_fixed_fee',
        'exchange_fee_percentage',
        'egx_fee_percentage',
        'misr_clearing_fee_percentage',
        'fra_fee_percentage',
    ];

    protected $casts = [
        'thunder_percentage' => 'float',
        'thunder_fixed_fee' => 'float',
        'exchange_fee_percentage' => 'float',
        'egx_fee_percentage' => 'float',
        'misr_clearing_fee_percentage' => 'float',
        'fra_fee_percentage' => 'float',
    ];

    public static function current(): self
    {
        return static::query()->firstOrCreate(['id' => 1]);
    }
}
