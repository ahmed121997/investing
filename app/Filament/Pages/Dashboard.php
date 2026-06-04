<?php

namespace App\Filament\Pages;

use App\Filament\Widgets\DepositWithdrawalStats;
use App\Filament\Widgets\TradeStats;
use App\Filament\Widgets\WalletStats;
use App\Filament\Widgets\OpenTradesPercentageChart;
use App\Filament\Widgets\SectorTradesPercentageChart;
use Filament\Pages\Dashboard as BaseDashboard;

class Dashboard extends BaseDashboard
{
    public function getWidgets(): array
    {
        return [
            WalletStats::class,
            DepositWithdrawalStats::class,
            TradeStats::class,
            OpenTradesPercentageChart::class,
            SectorTradesPercentageChart::class,
        ];
    }
}
