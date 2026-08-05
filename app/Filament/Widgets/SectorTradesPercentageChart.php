<?php

namespace App\Filament\Widgets;

use App\Models\Trade;
use Filament\Widgets\ChartWidget;

class SectorTradesPercentageChart extends ChartWidget
{
    protected ?string $heading = null;

    public function getHeading(): string
    {
        return __('app.dashboard.open_trade_value_by_sector');
    }

    protected function getData(): array
    {
        $sectorTrades = Trade::query()
            ->join('stocks', 'trades.stock_id', '=', 'stocks.id')
            ->leftJoin('sectors', 'stocks.sector_id', '=', 'sectors.id')
            ->where('trades.status', 'open')
            ->selectRaw('COALESCE(sectors.name_ar, ?) as sector_name', [__('app.dashboard.no_sector')])
            ->selectRaw('COALESCE(SUM(trades.amount * stocks.price), 0) as total')
            ->groupBy('sectors.id', 'sectors.name_ar')
            ->orderByDesc('total')
            ->get();

        $totalTradeValue = (float) $sectorTrades->sum('total');

        $colors = $this->getSectorColors($sectorTrades->count());

        return [
            'datasets' => [
                [
                    'label' => __('app.dashboard.trade_value'),
                    'data' => $sectorTrades->pluck('total')->map(fn ($total) => (float) $total)->toArray(),
                    'backgroundColor' => $colors,
                    'borderColor' => '#ffffff',
                    'borderWidth' => 2,
                ],
            ],
            'labels' => $sectorTrades->map(function ($item) use ($totalTradeValue) {
                $total = (float) $item->total;
                $percentage = $totalTradeValue > 0 ? round(($total / $totalTradeValue) * 100, 1) : 0;

                return $item->sector_name . ' (' . $percentage . '%)';
            })->toArray(),
        ];
    }

    protected function getType(): string
    {
        return 'doughnut';
    }

    private function getSectorColors(int $count): array
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
