<?php

namespace App\Providers;

use App\Models\TradeTrack;
use App\Observers\TradeTrackObserver;
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
        TradeTrack::observe(TradeTrackObserver::class);
    }
}
