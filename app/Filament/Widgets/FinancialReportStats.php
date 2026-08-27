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
        $latestReportIds = FinancialReport::query()
            ->selectRaw('MAX(id)')
            ->groupBy('stock_id');
        $reports = FinancialReport::with('stock')
            ->whereIn('id', $latestReportIds)
            ->latest()
            ->get();
        /** @var FinancialReport|null $topProfit */
        $topProfit = $reports->sortByDesc(fn (FinancialReport $report) => $report->growth('net_profit') ?? -INF)->first();
        /** @var FinancialReport|null $topEps */
        $topEps = $reports->sortByDesc(fn (FinancialReport $report) => $report->growth('eps') ?? -INF)->first();
        /** @var array{report: FinancialReport, metric: string, coverage: float}|null $bestCoverage */
        $bestCoverage = $reports->flatMap(fn (FinancialReport $report) => collect(['revenue', 'gross_profit', 'net_profit', 'eps'])->map(fn ($metric) => ['report' => $report, 'metric' => $metric, 'coverage' => $report->coverage($metric)]))->filter(fn ($item) => data_get($item, 'coverage') !== null)->sortByDesc('coverage')->first();
        $latest = $reports->first();
        $positiveGrowth = $reports->filter(fn (FinancialReport $report) => ($report->growth('net_profit') ?? 0) > 0)->count();
        $negativeGrowth = $reports->filter(fn (FinancialReport $report) => ($report->growth('net_profit') ?? 0) < 0)->count();
        $highestNetMargin = $reports->filter(fn (FinancialReport $report) => $report->net_margin !== null)->sortByDesc('net_margin')->first();
        $lowestDebtRatio = $reports->filter(fn (FinancialReport $report) => (float) $report->total_assets > 0)
            ->sortBy(fn (FinancialReport $report) => (float) $report->total_liabilities / (float) $report->total_assets)
            ->first();
        $totalReports = FinancialReport::count();
        $totalCompanies = FinancialReport::distinct('stock_id')->count('stock_id');

        return [
            Stat::make(__('financial_reports.top_growing_companies'), $topProfit?->stock?->code ?? '—')->description($topProfit ? number_format($topProfit->growth('net_profit'), 2).'%' : __('financial_reports.no_reports'))->color('success'),
            Stat::make(__('financial_reports.highest_eps_growth'), $topEps?->stock?->code ?? '—')->description($topEps ? number_format($topEps->growth('eps'), 2).'%' : __('financial_reports.no_reports'))->color('primary'),
            Stat::make(__('financial_reports.best_coverage'), data_get($bestCoverage, 'report.stock.code', '—'))->description($bestCoverage ? __('financial_reports.'.data_get($bestCoverage, 'metric')).': '.number_format(data_get($bestCoverage, 'coverage'), 2).'%' : __('financial_reports.no_reports'))->color('warning'),
            Stat::make(__('financial_reports.latest_financial_reports'), $latest?->stock?->code ?? '—')->description($latest?->period_a_title ?? __('financial_reports.no_reports'))->color('gray'),
            Stat::make(__('financial_reports.total_reports'), $totalReports)->description(__('financial_reports.all_financial_reports'))->color('gray'),
            Stat::make(__('financial_reports.companies_covered'), $totalCompanies)->description(__('financial_reports.unique_stocks'))->color('primary'),
            Stat::make(__('financial_reports.net_profit_direction'), $positiveGrowth.' / '.$negativeGrowth)->description(__('financial_reports.positive_negative_growth'))->color($positiveGrowth >= $negativeGrowth ? 'success' : 'danger'),
            Stat::make(__('financial_reports.highest_net_margin'), $highestNetMargin?->stock?->code ?? '—')->description($highestNetMargin ? number_format((float) $highestNetMargin->net_margin, 2).'%' : __('financial_reports.no_reports'))->color('success'),
            Stat::make(__('financial_reports.lowest_debt_ratio'), $lowestDebtRatio?->stock?->code ?? '—')->description($lowestDebtRatio ? number_format(((float) $lowestDebtRatio->total_liabilities / (float) $lowestDebtRatio->total_assets) * 100, 2).'%' : __('financial_reports.no_reports'))->color('warning'),
        ];
    }
}
