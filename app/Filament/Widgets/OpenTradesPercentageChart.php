<?php

namespace App\Filament\Widgets;

use App\Models\Trade;
use App\Models\Wallet;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\Auth;

class OpenTradesPercentageChart extends ChartWidget
{
    protected ?string $heading = null;

    public function getHeading(): string
    {
        return __('app.dashboard.wallet_allocation');
    }

    protected function getData(): array
    {
        $stockAllocations = Trade::query()
            ->join('stocks', 'stocks.id', '=', 'trades.stock_id')
            ->where('trades.status', 'open')
            ->selectRaw('stocks.code as stock_code')
            ->selectRaw('COALESCE(SUM(trades.amount * stocks.price), 0) as total')
            ->groupBy('stocks.id', 'stocks.code')
            ->orderByDesc('total')
            ->get();

        $openTradesTotal = (float) $stockAllocations->sum('total');

        $wallet = Wallet::query()->firstOrCreate(
            ['user_id' => Auth::id()],
            ['cash' => 0, 'save_cloud' => 0],
        );

        $liquidityTotal = (float) $wallet->cash + (float) $wallet->save_cloud;
        $walletTotal = $openTradesTotal + $liquidityTotal;

        $data = $stockAllocations->pluck('total')->map(fn ($total) => (float) $total)->toArray();
        $labels = $stockAllocations->map(function ($stock) use ($walletTotal) {
            $total = (float) $stock->total;
            $percentage = $walletTotal > 0 ? round(($total / $walletTotal) * 100, 1) : 0;

            return $stock->stock_code . ' (' . $percentage . '%)';
        })->toArray();

        if ($liquidityTotal > 0) {
            $data[] = $liquidityTotal;
            $labels[] = __('app.dashboard.liquidity_percentage', ['percentage' => round(($liquidityTotal / $walletTotal) * 100, 1)]);
        }

        return [
            'datasets' => [
                [
                    'label' => __('app.dashboard.wallet'),
                    'data' => $data,
                    'backgroundColor' => $this->getAllocationColors(count($data)),
                    'borderColor' => '#ffffff',
                    'borderWidth' => 2,
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'doughnut';
    }

    private function getAllocationColors(int $count): array
    {
        $colors = [
            '#FF6384',
            '#36A2EB',
            '#FFCE56',
            '#4BC0C0',
            '#9966FF',
            '#FF9F40',
            '#C9CBCF',
            '#2ECC71',
            '#E74C3C',
            '#34495E',
            '#1ABC9C',
            '#9B59B6',
            '#F1C40F',
            '#E67E22',
            '#7F8C8D',
        ];

        for ($index = count($colors); $index < $count; $index++) {
            $hue = ($index * 137) % 360;
            $colors[] = "hsl({$hue}, 70%, 55%)";
        }

        return array_slice($colors, 0, $count);
    }
}
