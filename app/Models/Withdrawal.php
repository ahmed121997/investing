<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Withdrawal extends Model
{
    protected $fillable = ['user_id', 'amount', 'withdrawal_date', 'description'];

    protected $casts = [
        'amount' => 'decimal:2',
        'withdrawal_date' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
