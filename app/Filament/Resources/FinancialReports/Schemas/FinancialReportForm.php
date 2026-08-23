<?php

namespace App\Filament\Resources\FinancialReports\Schemas;

use App\Enums\FinancialPeriodType;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class FinancialReportForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Section::make(__('financial_reports.company'))->schema([
                Select::make('stock_id')->label(__('financial_reports.stock'))->options(fn () => \App\Models\Stock::all()->mapWithKeys(fn ($stock) => [$stock->id => "{$stock->name} ({$stock->code})"]))->required()->searchable(),
            ]),
            Section::make(__('financial_reports.projection'))->columns(2)->schema([
                Toggle::make('enable_projection')->label(__('financial_reports.enable_projection'))->live(),
                TextInput::make('projection_multiplier')->label(__('financial_reports.projection_multiplier'))->numeric()->default(2)->minValue(0)->visible(fn ($get) => $get('enable_projection')),
            ]),
            Section::make(__('financial_reports.periods'))->columns(2)->schema([
                ...self::periodFields('a', __('financial_reports.current_period')),
                ...self::periodFields('b', __('financial_reports.base_period')),
            ]),
            Section::make(__('financial_reports.financial_metrics'))->columns(2)->schema([
                ...self::metricFields('revenue'), ...self::metricFields('gross_profit'), ...self::metricFields('net_profit'), ...self::metricFields('eps'),
            ]),

            Section::make(__('financial_reports.additional_kpis'))->collapsed()->columns(4)->schema([
                ...collect(['operating_profit', 'operating_margin', 'net_margin', 'book_value', 'cash_balance', 'total_assets', 'total_liabilities', 'shareholders_equity'])
                    ->map(fn ($field) => TextInput::make($field)->label(__('financial_reports.'.$field))->numeric()->step(0.000001))->all(),
            ]),
            Section::make(__('financial_reports.summary_notes'))->schema([
                RichEditor::make('summary_notes')->label(__('financial_reports.summary_notes'))->columnSpanFull(),
            ]),
        ]);
    }

    private static function periodFields(string $key, string $heading): array
    {
        return [
            Section::make($heading)->columns(2)->schema([
                Select::make("period_{$key}_type")->label(__('financial_reports.period_type'))->options(collect(FinancialPeriodType::cases())->mapWithKeys(fn ($type) => [$type->value => $type->label()]))->required(),
                TextInput::make("period_{$key}_year")->label(__('financial_reports.period_year'))->numeric()->minValue(1900)->maxValue(9999),
                TextInput::make("period_{$key}_month")->label(__('financial_reports.period_month'))->numeric()->minValue(1)->maxValue(12),
                TextInput::make("period_{$key}_title")->label(__('financial_reports.period_title'))->required()->maxLength(255),
            ]),
        ];
    }

    private static function metricFields(string $metric): array
    {
        return [
            Section::make(__('financial_reports.'.$metric))->columns(2)->schema([
                TextInput::make("{$metric}_a")->label(__('financial_reports.current_period'))->numeric()->step(0.000001),
                TextInput::make("{$metric}_b")->label(__('financial_reports.base_period'))->numeric()->step(0.000001),
                Textarea::make("{$metric}_note")->label(__('financial_reports.analyst_note'))->columnSpanFull()->rows(2),
            ]),
        ];
    }
}
