<?php

namespace App\Providers;

use App\Models\Deposit;
use App\Models\TradeTrack;
use App\Models\Withdrawal;
use App\Observers\DepositObserver;
use App\Observers\TradeTrackObserver;
use App\Observers\WithdrawalObserver;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Deposit::observe(DepositObserver::class);
        TradeTrack::observe(TradeTrackObserver::class);
        Withdrawal::observe(WithdrawalObserver::class);
    }
}
