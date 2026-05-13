<?php

namespace App\Models;

use App\Models\Trade;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TradeTrack extends Model
{
    protected $fillable = [
        'trade_id',
        'amount',
        'date',
        'type',
    ];


    protected $casts = [
        'amount' => 'double',
        'date' => 'datetime',
        'type' => 'string:in:buy,sell,profit',
    ];

    public function trade(): BelongsTo
    {
        return $this->belongsTo(Trade::class);
    }
}
