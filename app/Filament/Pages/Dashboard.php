<?php

namespace App\Filament\Pages;

use App\Filament\Widgets\DepositWithdrawalStats;
use App\Filament\Widgets\TradeStats;
use App\Filament\Widgets\WalletStats;
use App\Filament\Widgets\OpenTradesPercentageChart;
use App\Filament\Widgets\OpenStocksLiquidityChart;
use App\Filament\Widgets\SectorTradesPercentageChart;
use App\Filament\Widgets\TopProfitStocksChart;
use Filament\Pages\Dashboard as BaseDashboard;
use App\Filament\Widgets\FinancialReportStats;
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
            OpenStocksLiquidityChart::class,
            TopProfitStocksChart::class,
            FinancialReportStats::class,
        ];
    }
}
