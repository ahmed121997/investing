<?php

namespace App\Filament\Widgets;

use App\Models\Trade;
use App\Models\Wallet;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\Auth;

class OpenStocksLiquidityChart extends ChartWidget
{
    protected ?string $heading = null;

    public function getHeading(): string
    {
        return __('app.dashboard.open_stocks_vs_total_liquidity');
    }

    protected function getData(): array
    {
        $openStocksTotal = (float) Trade::query()
            ->join('stocks', 'stocks.id', '=', 'trades.stock_id')
            ->where('trades.status', 'open')
            ->where('trades.user_id', Auth::id())
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
                    'label' => __('app.dashboard.wallet_value'),
                    'data' => [$openStocksTotal, $liquidityTotal],
                    'backgroundColor' => ['#2563EB', '#16A34A'],
                    'borderColor' => '#ffffff',
                    'borderWidth' => 2,
                ],
            ],
            'labels' => [
                __('app.dashboard.open_stocks_percentage', ['percentage' => $this->percentage($openStocksTotal, $total)]),
                __('app.dashboard.total_liquidity_percentage', ['percentage' => $this->percentage($liquidityTotal, $total)]),
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
