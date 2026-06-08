<?php

namespace App\Filament\Widgets;

use App\Models\Trade;
use App\Models\Wallet;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\Auth;

class OpenStocksLiquidityChart extends ChartWidget
{
    protected ?string $heading = 'Open Stocks vs Total Liquidity';

    protected function getData(): array
    {
        $openStocksTotal = (float) Trade::query()
            ->join('stocks', 'stocks.id', '=', 'trades.stock_id')
            ->where('trades.status', 'open')
            ->selectRaw('COALESCE(SUM(trades.amount * stocks.price), 0) as total')
            ->value('total');

        $wallet = Wallet::query()->firstOrCreate(
            ['user_id' => Auth::id()],
            ['cash' => 0, 'save_cloud' => 0],
        );

        $liquidityTotal = (float) $wallet->cash + (float) $wallet->save_cloud;
        $total = $openStocksTotal + $liquidityTotal;

        return [
            'datasets' => [
                [
                    'label' => 'Wallet Value',
                    'data' => [$openStocksTotal, $liquidityTotal],
                    'backgroundColor' => ['#2563EB', '#16A34A'],
                    'borderColor' => '#ffffff',
                    'borderWidth' => 2,
                ],
            ],
            'labels' => [
                'Open Stocks (' . $this->percentage($openStocksTotal, $total) . '%)',
                'Total Liquidity (' . $this->percentage($liquidityTotal, $total) . '%)',
            ],
        ];
    }

    protected function getType(): string
    {
        return 'doughnut';
    }

    private function percentage(float $amount, float $total): float
    {
        return $total > 0 ? round(($amount / $total) * 100, 1) : 0;
    }
}
