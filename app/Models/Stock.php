<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Stock extends Model
{
    protected $fillable = [
        'name',
        'code',
        'market',
        'price',
    ];

    protected $casts = [
        'price' => 'double',
    ];

    public function trades(): HasMany
    {
        return $this->hasMany(Trade::class);
    }
}
