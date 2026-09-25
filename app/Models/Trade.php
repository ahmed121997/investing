<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Auth;

class Trade extends Model
{
    protected $fillable = [
        'stock_id',
        'amount', // amount stocks
        'status',
        'year',
        'closed_at',
    ];

    protected $appends = ['current_total', 'total_trades_amount', 'profit_loss', 'profit_percentage'];

    protected $casts = [
        'amount' => 'double',
        'status' => 'string',
        'year' => 'integer',
        'closed_at' => 'datetime',
    ];

    protected static function booted(): void
    {
        static::creating(function (Trade $trade): void {
            $trade->user_id ??= Auth::id();
            $trade->year ??= (int) now()->year;
        });
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

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

    public function getDaysOpenAttribute(): ?int
    {
        if (! $this->closed_at) {
            return null;
        }

        return (int) $this->closed_at->diffInDays($this->created_at);
    }

    public function getProfitPercentageAttribute(): ?float
    {
        $tracks = $this->tradeTracks()->get();
        $totalBuyAmount = $tracks->where('type', 'buy')->sum('amount');
        $totalSellAmount = $tracks->whereIn('type', ['sell', 'profit'])->sum('amount');

        if ($totalBuyAmount == 0) {
            return null;
        }

        $profit = $totalSellAmount + $this->current_total + $totalBuyAmount;

        return ($profit / abs($totalBuyAmount)) * 100;
    }
}
