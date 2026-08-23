<?php

namespace App\Filament\Resources\FinancialReports;

use App\Filament\Resources\FinancialReports\Pages\CreateFinancialReport;
use App\Filament\Resources\FinancialReports\Pages\EditFinancialReport;
use App\Filament\Resources\FinancialReports\Pages\ListFinancialReports;
use App\Filament\Resources\FinancialReports\Pages\ViewFinancialReport;
use App\Filament\Resources\FinancialReports\Schemas\FinancialReportForm;
use App\Filament\Resources\FinancialReports\Tables\FinancialReportsTable;
use App\Models\FinancialReport;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;

class FinancialReportResource extends Resource
{
    protected static ?string $model = FinancialReport::class;
    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-chart-bar-square';

    public static function getNavigationGroup(): ?string { return __('financial_reports.navigation_group'); }
    public static function getNavigationLabel(): string { return __('financial_reports.financial_reports'); }
    public static function getModelLabel(): string { return __('financial_reports.financial_report'); }
    public static function getPluralModelLabel(): string { return __('financial_reports.financial_reports'); }
    public static function getNavigationSort(): ?int { return 5; }
    public static function form(Schema $schema): Schema { return FinancialReportForm::configure($schema); }
    public static function table(Table $table): Table { return FinancialReportsTable::configure($table); }
    public static function getPages(): array
    {
        return [
            'index' => ListFinancialReports::route('/'),
            'create' => CreateFinancialReport::route('/create'),
            'view' => ViewFinancialReport::route('/{record}'),
            'edit' => EditFinancialReport::route('/{record}/edit'),
        ];
    }
}
