<?php

namespace App\Providers;

use App\Models\Deposit;
use App\Models\TradeTrack;
use App\Models\User;
use App\Models\Withdrawal;
use App\Observers\DepositObserver;
use App\Observers\TradeTrackObserver;
use App\Observers\WithdrawalObserver;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;

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
        Gate::define('manage-translations', fn (User $user): bool => $user->isAdmin());

        Deposit::observe(DepositObserver::class);
        TradeTrack::observe(TradeTrackObserver::class);
        Withdrawal::observe(WithdrawalObserver::class);
    }
}
