<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WalletLog extends Model
{
    protected $fillable = [
        'wallet_id',
        'trade_track_id',
        'trade_id',
        'action',
        'transaction_type',
        'amount',
        'cash_change',
        'cash_before',
        'cash_after',
        'save_cloud_before',
        'save_cloud_after',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'cash_change' => 'decimal:2',
        'cash_before' => 'decimal:2',
        'cash_after' => 'decimal:2',
        'save_cloud_before' => 'decimal:2',
        'save_cloud_after' => 'decimal:2',
    ];

    public function wallet(): BelongsTo
    {
        return $this->belongsTo(Wallet::class);
    }
}
