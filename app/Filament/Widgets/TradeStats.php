<?php

namespace App\Filament\Widgets;

use App\Models\Sector;
use App\Models\Trade;
use App\Models\TradeTrack;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class TradeStats extends BaseWidget
{
    protected ?string $heading = null;

    public function getHeading(): string
    {
        return __('app.dashboard.trade_statistics');
    }

    protected function getStats(): array
    {
        $totalTrades = Trade::count();
        $totalOpenTrades = Trade::where('status', 'open')->count();
        $totalClosedTrades = Trade::where('status', 'close')->count();
        $totalSectors = Sector::count();

        $tradeTrackTotals = TradeTrack::query()
            ->select('trade_id')
            ->selectRaw('SUM(amount) as total_amount')
            ->groupBy('trade_id');

        $profitLossExpression = '(trades.amount * stocks.price) + COALESCE(trade_track_totals.total_amount, 0)';

        $profitLossCounts = Trade::query()
            ->join('stocks', 'stocks.id', '=', 'trades.stock_id')
            ->leftJoinSub($tradeTrackTotals, 'trade_track_totals', function ($join) {
                $join->on('trade_track_totals.trade_id', '=', 'trades.id');
            })
            ->selectRaw("SUM(CASE WHEN {$profitLossExpression} > 0 THEN 1 ELSE 0 END) as winning_trades")
            ->selectRaw("SUM(CASE WHEN {$profitLossExpression} < 0 THEN 1 ELSE 0 END) as losing_trades")
            ->selectRaw("SUM({$profitLossExpression}) as total_profit_loss")
            ->first();

        $totalProfitLoss = (float) ($profitLossCounts->total_profit_loss ?? 0);

        return [
            Stat::make(__('app.dashboard.total_trades'), $totalTrades)
                ->description(__('app.dashboard.all_trades'))
                ->descriptionIcon('heroicon-m-squares-2x2')
                ->color('primary'),
            Stat::make(__('app.dashboard.open_trades'), $totalOpenTrades)
                ->description(__('app.dashboard.trades_currently_open'))
                ->descriptionIcon('heroicon-m-lock-open')
                ->color('success'),
            Stat::make(__('app.dashboard.closed_trades'), $totalClosedTrades)
                ->description(__('app.dashboard.trades_currently_closed'))
                ->descriptionIcon('heroicon-m-lock-closed')
                ->color('gray'),
            Stat::make(__('app.dashboard.sectors'), $totalSectors)
                ->description(__('app.dashboard.total_market_sectors'))
                ->descriptionIcon('heroicon-m-building-office-2')
                ->color('warning'),
            Stat::make(__('app.dashboard.win_trades'), (int) ($profitLossCounts->winning_trades ?? 0))
                ->description(__('app.dashboard.trades_with_profit'))
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('success'),
            Stat::make(__('app.dashboard.loss_trades'), (int) ($profitLossCounts->losing_trades ?? 0))
                ->description(__('app.dashboard.trades_with_loss'))
                ->descriptionIcon('heroicon-m-arrow-trending-down')
                ->color('danger'),
            Stat::make(__('app.dashboard.draw_trades'), $totalTrades - (int) ($profitLossCounts->winning_trades ?? 0) - (int) ($profitLossCounts->losing_trades ?? 0))
                ->descriptionIcon('heroicon-m-chart-bar-square')
                ->color('warning'),

            Stat::make(__('app.dashboard.total_profit_loss'), number_format($totalProfitLoss, 2))
                ->description($totalProfitLoss >= 0 ? __('app.dashboard.total_portfolio_profit') : __('app.dashboard.total_portfolio_loss'))
                ->descriptionIcon($totalProfitLoss >= 0 ? 'heroicon-m-arrow-trending-up' : 'heroicon-m-arrow-trending-down')
                ->color($totalProfitLoss >= 0 ? 'success' : 'danger'),


        ];
    }
}
