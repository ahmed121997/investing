<?php

namespace App\Filament\Widgets;

use App\Models\Deposit;
use App\Models\Trade;
use App\Models\TradeTrack;
use App\Models\User;
use App\Models\Wallet;
use App\Models\Withdrawal;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class AdminOverviewStats extends BaseWidget
{
    protected ?string $heading = null;

    public function getHeading(): string
    {
        return __('app.admin_overview');
    }

    protected function getStats(): array
    {
        $totalProfitLoss = (float) Trade::query()
            ->join('stocks', 'stocks.id', '=', 'trades.stock_id')
            ->leftJoinSub(
                TradeTrack::query()
                    ->select('trade_id')
                    ->selectRaw('SUM(amount) as total_amount')
                    ->groupBy('trade_id'),
                'trade_track_totals',
                fn ($join) => $join->on('trade_track_totals.trade_id', '=', 'trades.id'),
            )
            ->selectRaw('SUM((trades.amount * stocks.price) + COALESCE(trade_track_totals.total_amount, 0)) as total')
            ->value('total');

        return [
            Stat::make(__('app.users'), User::count())
                ->description(__('app.active_users').': '.User::where('is_active', true)->count())
                ->descriptionIcon('heroicon-m-users')
                ->color('primary'),
            Stat::make(__('app.total_deposits'), '$'.number_format((float) Deposit::sum('amount'), 2))
                ->description(__('app.all_accounts'))
                ->descriptionIcon('heroicon-m-arrow-up-circle')
                ->color('success'),
            Stat::make(__('app.total_withdrawals'), '$'.number_format((float) Withdrawal::sum('amount'), 2))
                ->description(__('app.all_accounts'))
                ->descriptionIcon('heroicon-m-arrow-down-circle')
                ->color('danger'),
            Stat::make(__('app.wallet_cash'), '$'.number_format((float) Wallet::sum('cash'), 2))
                ->description(__('app.all_accounts'))
                ->descriptionIcon('heroicon-m-banknotes')
                ->color('warning'),
            Stat::make(__('app.total_trades'), Trade::count())
                ->description(__('app.open_trades').': '.Trade::where('status', 'open')->count())
                ->descriptionIcon('heroicon-m-chart-bar')
                ->color('info'),
            Stat::make(__('app.total_profit_loss'), number_format($totalProfitLoss, 2))
                ->description(__('app.all_accounts'))
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color($totalProfitLoss >= 0 ? 'success' : 'danger'),
        ];
    }
}
