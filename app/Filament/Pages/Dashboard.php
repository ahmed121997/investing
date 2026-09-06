<?php

namespace App\Filament\Pages;

use App\Filament\Widgets\AdminOverviewStats;
use App\Filament\Widgets\DepositWithdrawalStats;
use App\Filament\Widgets\FinancialReportStats;
use App\Filament\Widgets\OpenStocksLiquidityChart;
use App\Filament\Widgets\OpenTradesPercentageChart;
use App\Filament\Widgets\SectorTradesPercentageChart;
use App\Filament\Widgets\TopProfitStocksChart;
use App\Filament\Widgets\TradeStats;
use App\Filament\Widgets\WalletStats;
use App\Models\User;
use Filament\Pages\Dashboard as BaseDashboard;
use Illuminate\Support\Facades\Auth;

class Dashboard extends BaseDashboard
{
    public function getWidgets(): array
    {
        if (User::query()->whereKey(Auth::id())->where('role', 'admin')->exists()) {
            return [AdminOverviewStats::class];
        }

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
