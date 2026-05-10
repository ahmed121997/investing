<?php

namespace App\Models;

use App\Models\Stock;
use App\Models\TradeTrack;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Trade extends Model
{
    protected $fillable = [
        'stock_id',
        'amount', // amount stocks
        'status',
    ];
    protected $appends = ['current_total','total_trades_amount' ,'profit_loss'];
    protected $casts = [
        'amount' => 'double',
        'status' => 'string',
    ];

    public function stock(): BelongsTo
    {
        return $this->belongsTo(Stock::class);
    }

    public function tradeTracks(): HasMany
    {
        return $this->hasMany(TradeTrack::class)->orderByDesc('date');
    }

    public function getCurrentTotalAttribute()
    {
        return $this->amount * $this->stock->price;
    }

    public function getTotalTradesAmountAttribute()
    {
        return $this->tradeTracks()->sum('amount');
    }

    public function getProfitLossAttribute()
    {
        return $this->current_total + $this->total_trades_amount;
    }
}
