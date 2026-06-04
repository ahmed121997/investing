<?php

namespace App\Filament\Widgets;

use App\Models\Trade;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;

class OpenTradesPercentageChart extends ChartWidget
{
    protected ?string $heading = 'Open vs Closed Trades';

    protected function getData(): array
    {
        $totalTrades = Trade::count();
        $openTrades = Trade::where('status', 'open')->count();
        $closedTrades = Trade::where('status', 'close')->count();

        return [
            'datasets' => [
                [
                    'label' => 'Trades',
                    'data' => [$openTrades, $closedTrades],
                    'backgroundColor' => [
                        '#10b981', // green for open
                        '#6b7280', // gray for closed
                    ],
                    'borderColor' => '#ffffff',
                    'borderWidth' => 2,
                ],
            ],
            'labels' => [
                'Open (' . ($totalTrades > 0 ? round(($openTrades / $totalTrades) * 100, 1) : 0) . '%)',
                'Closed (' . ($totalTrades > 0 ? round(($closedTrades / $totalTrades) * 100, 1) : 0) . '%)',
            ],
        ];
    }

    protected function getType(): string
    {
        return 'doughnut';
    }
}
