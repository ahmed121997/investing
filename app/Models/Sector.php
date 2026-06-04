<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Sector extends Model
{
    protected $fillable = [
        'name',
        'name_ar',
    ];

    public function stocks(): HasMany
    {
        return $this->hasMany(Stock::class);
    }
}
