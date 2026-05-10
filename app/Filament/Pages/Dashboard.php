<?php

namespace App\Filament\Pages;

use App\Filament\Widgets\DepositWithdrawalStats;
use App\Filament\Widgets\TradeStats;
use Filament\Pages\Dashboard as BaseDashboard;

class Dashboard extends BaseDashboard
{
    public function getWidgets(): array
    {
        return [
            DepositWithdrawalStats::class,
            TradeStats::class,
        ];
    }
}
