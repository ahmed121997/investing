<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Stock extends Model
{
    protected $fillable = [
        'name',
        'code',
        'market',
        'price',
        'sector_id',
    ];

    protected $casts = [
        'price' => 'double',
    ];

    public function trades(): HasMany
    {
        return $this->hasMany(Trade::class);
    }

    public function sector(): BelongsTo
    {
        return $this->belongsTo(Sector::class);
    }

    public function getPriceAttribute(int|float|string|null $value): string
    {
        return $value >= 1 ? number_format($value, 2) : number_format($value, 3);
    }
}
