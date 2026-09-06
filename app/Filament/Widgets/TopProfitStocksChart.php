<?php

namespace App\Filament\Widgets;

use App\Models\Trade;
use App\Models\TradeTrack;
use Filament\Forms\Components\Select;
use Filament\Schemas\Schema;
use Filament\Widgets\ChartWidget;
use Filament\Widgets\ChartWidget\Concerns\HasFiltersSchema;
use Illuminate\Support\Facades\Auth;

class TopProfitStocksChart extends ChartWidget
{
    use HasFiltersSchema;

    protected ?string $heading = null;

    public function getHeading(): string
    {
        return __('app.dashboard.top_profit_stocks');
    }

    public function filtersSchema(Schema $schema): Schema
    {
        $years = Trade::query()
            ->where('user_id', Auth::id())
            ->whereNotNull('year')
            ->distinct()
            ->orderByDesc('year')
            ->pluck('year')
            ->map(fn (int $year): int => $year)
            ->push((int) now()->year)
            ->unique()
            ->sortDesc()
            ->values()
            ->all();

        $yearOptions = ['all' => __('app.all')];
        foreach ($years as $year) {
            $yearOptions[(string) $year] = (string) $year;
        }

        return $schema->components([
            Select::make('year')
                ->label(__('app.year'))
                ->options($yearOptions)
                ->default('all')
                ->native(false),
            Select::make('status')
                ->label(__('app.status'))
                ->options([
                    'all' => __('app.all'),
                    'open' => __('app.open'),
                    'close' => __('app.close'),
                ])
                ->default('all')
                ->native(false),
        ]);
    }

    public function getTopProfitStocksData(): array
    {
        $selectedYear = $this->filters['year'] ?? 'all';
        $selectedStatus = $this->filters['status'] ?? 'all';

        $tradeTrackTotals = TradeTrack::query()
            ->whereHas('trade', fn ($query) => $query->where('user_id', Auth::id()))
            ->select('trade_id')
            ->selectRaw('SUM(amount) as total_amount')
            ->groupBy('trade_id');

        $stockProfitQuery = Trade::query()
            ->where('trades.user_id', Auth::id())
            ->join('stocks', 'stocks.id', '=', 'trades.stock_id')
            ->leftJoinSub($tradeTrackTotals, 'trade_track_totals', function ($join) {
                $join->on('trade_track_totals.trade_id', '=', 'trades.id');
            });

        if ($selectedYear !== 'all') {
            $stockProfitQuery->where('trades.year', (int) $selectedYear);
        }

        if ($selectedStatus !== 'all') {
            $stockProfitQuery->where('trades.status', $selectedStatus);
        }

        $stockProfit = $stockProfitQuery
            ->selectRaw('stocks.id as stock_id')
            ->selectRaw('stocks.code as stock_code')
            ->selectRaw('SUM((trades.amount * stocks.price) + COALESCE(trade_track_totals.total_amount, 0)) as total_profit')
            ->groupBy('stocks.id', 'stocks.code')
            ->orderByDesc('total_profit')
            ->limit(10)
            ->get();

        if ($stockProfit->isEmpty()) {
            return [
                'labels' => ['-'],
                'datasets' => [[
                    'label' => __('app.dashboard.total_profit_loss'),
                    'data' => [0],
                    'backgroundColor' => ['#9CA3AF'],
                    'borderRadius' => 6,
                ]],
            ];
        }

        return [
            'datasets' => [
                [
                    'label' => __('app.dashboard.total_profit_loss'),
                    'data' => $stockProfit->pluck('total_profit')->map(fn ($value) => (float) $value)->toArray(),
                    'backgroundColor' => $this->getBarColors($stockProfit->count()),
                    'borderColor' => '#ffffff',
                    'borderWidth' => 1,
                    'borderRadius' => 6,
                ],
            ],
            'labels' => $stockProfit->pluck('stock_code')->toArray(),
        ];
    }

    protected function getData(): array
    {
        return $this->getTopProfitStocksData();
    }

    protected function getType(): string
    {
        return 'bar';
    }

    private function getBarColors(int $count): array
    {
        $colors = [
            '#22C55E',
            '#3B82F6',
            '#F59E0B',
            '#10B981',
            '#8B5CF6',
            '#EF4444',
            '#14B8A6',
            '#F97316',
            '#EC4899',
            '#6366F1',
        ];

        return array_slice(array_pad($colors, $count, '#22C55E'), 0, $count);
    }
}
