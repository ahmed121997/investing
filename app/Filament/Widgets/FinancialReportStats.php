<?php

namespace App\Filament\Widgets;

use App\Models\FinancialReport;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class FinancialReportStats extends BaseWidget
{
    protected ?string $heading = null;

    public function getHeading(): string { return __('financial_reports.dashboard_heading'); }

    protected function getStats(): array
    {
        $reports = FinancialReport::with('stock')->latest()->get();
        $topProfit = $reports->sortByDesc(fn ($r) => $r->growth('net_profit') ?? -INF)->first();
        $topEps = $reports->sortByDesc(fn ($r) => $r->growth('eps') ?? -INF)->first();
        $bestCoverage = $reports->flatMap(fn ($r) => collect(['revenue', 'gross_profit', 'net_profit', 'eps'])->map(fn ($metric) => ['report' => $r, 'metric' => $metric, 'coverage' => $r->coverage($metric)]))->filter(fn ($item) => $item['coverage'] !== null)->sortByDesc('coverage')->first();
        $latest = $reports->first();
        return [
            Stat::make(__('financial_reports.top_growing_companies'), $topProfit?->stock?->code ?? '—')->description($topProfit ? number_format($topProfit->growth('net_profit'), 2).'%' : __('financial_reports.no_reports'))->color('success'),
            Stat::make(__('financial_reports.highest_eps_growth'), $topEps?->stock?->code ?? '—')->description($topEps ? number_format($topEps->growth('eps'), 2).'%' : __('financial_reports.no_reports'))->color('primary'),
            Stat::make(__('financial_reports.best_coverage'), data_get($bestCoverage, 'report.stock.code', '—'))->description($bestCoverage ? __('financial_reports.'.$bestCoverage['metric']).': '.number_format($bestCoverage['coverage'], 2).'%' : __('financial_reports.no_reports'))->color('warning'),
            Stat::make(__('financial_reports.latest_financial_reports'), $latest?->stock?->code ?? '—')->description($latest?->period_a_title ?? __('financial_reports.no_reports'))->color('gray'),
        ];
    }
}
