<?php

namespace App\Filament\Widgets;

use App\Models\Trade;
use App\Models\TradeTrack;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class TradeStats extends BaseWidget
{
    protected ?string $heading = 'Trade Statistics';

    protected function getStats(): array
    {
        $totalTrades = Trade::count();
        $totalOpenTrades = Trade::where('status', 'open')->count();
        $totalClosedTrades = Trade::where('status', 'close')->count();

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
            Stat::make('Total Trades', $totalTrades)
                ->description('All trades')
                ->descriptionIcon('heroicon-m-squares-2x2')
                ->color('primary'),
            Stat::make('Open Trades', $totalOpenTrades)
                ->description('Trades currently open')
                ->descriptionIcon('heroicon-m-lock-open')
                ->color('success'),
            Stat::make('Closed Trades', $totalClosedTrades)
                ->description('Trades currently closed')
                ->descriptionIcon('heroicon-m-lock-closed')
                ->color('gray'),
            Stat::make('Win Trades', (int) ($profitLossCounts->winning_trades ?? 0))
                ->description('Trades with profit')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('success'),
            Stat::make('Loss Trades', (int) ($profitLossCounts->losing_trades ?? 0))
                ->description('Trades with loss')
                ->descriptionIcon('heroicon-m-arrow-trending-down')
                ->color('danger'),
            Stat::make('Total Profit/Loss', number_format($totalProfitLoss, 2))
                ->description($totalProfitLoss >= 0 ? 'Total portfolio profit' : 'Total portfolio loss')
                ->descriptionIcon($totalProfitLoss >= 0 ? 'heroicon-m-arrow-trending-up' : 'heroicon-m-arrow-trending-down')
                ->color($totalProfitLoss >= 0 ? 'success' : 'danger'),
        
        ];
    }
}
