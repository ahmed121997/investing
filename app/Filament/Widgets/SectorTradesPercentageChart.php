<?php

namespace App\Filament\Widgets;

use App\Models\Trade;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;

class SectorTradesPercentageChart extends ChartWidget
{
    protected ?string $heading = 'Trades by Sector';

    protected function getData(): array
    {
        $sectorTrades = Trade::query()
            ->join('stocks', 'trades.stock_id', '=', 'stocks.id')
            ->leftJoin('sectors', 'stocks.sector_id', '=', 'sectors.id')
            ->selectRaw('COALESCE(sectors.name_ar, "No Sector") as sector_name')
            ->selectRaw('COUNT(trades.id) as trade_count')
            ->groupBy('sectors.id', 'sectors.name_ar')
            ->orderByDesc('trade_count')
            ->get();

        $totalTrades = $sectorTrades->sum('trade_count');

        $colors = [
            '#3b82f6', '#ef4444', '#10b981', '#f59e0b', '#8b5cf6',
            '#ec4899', '#14b8a6', '#f97316', '#06b6d4', '#84cc16',
            '#6366f1', '#d946ef', '#0ea5e9', '#6ee7b7', '#fbbf24',
        ];

        return [
            'datasets' => [
                [
                    'label' => 'Number of Trades',
                    'data' => $sectorTrades->pluck('trade_count')->toArray(),
                    'backgroundColor' => array_slice($colors, 0, count($sectorTrades)),
                    'borderColor' => '#ffffff',
                    'borderWidth' => 2,
                ],
            ],
            'labels' => $sectorTrades->map(function ($item) use ($totalTrades) {
                $percentage = $totalTrades > 0 ? round(($item->trade_count / $totalTrades) * 100, 1) : 0;
                return $item->sector_name . ' (' . $percentage . '%)';
            })->toArray(),
        ];
    }

    protected function getType(): string
    {
        return 'doughnut';
    }
}
