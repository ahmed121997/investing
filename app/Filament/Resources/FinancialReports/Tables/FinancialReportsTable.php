<?php

namespace App\Filament\Resources\FinancialReports\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class FinancialReportsTable
{
    public static function configure(Table $table): Table
    {
        return $table->columns([
            TextColumn::make('stock.code')->label(__('financial_reports.stock_symbol'))->searchable()->sortable(),
            TextColumn::make('stock.name')->label(__('financial_reports.stock'))->searchable()->sortable(),
            TextColumn::make('period_a_title')->label(__('financial_reports.current_period'))->searchable(),
            TextColumn::make('period_b_title')->label(__('financial_reports.base_period'))->searchable(),
            TextColumn::make('net_profit_growth')->label(__('financial_reports.net_profit_growth'))->suffix('%')->color(fn ($state) => $state >= 0 ? 'success' : 'danger'),
            TextColumn::make('eps_growth')->label(__('financial_reports.eps_growth'))->suffix('%')->color(fn ($state) => $state >= 0 ? 'success' : 'danger'),
        ])->filters([
            SelectFilter::make('stock_id')->label(__('financial_reports.stock'))->relationship('stock', 'code')->searchable()->preload(),
        ])->recordActions([ViewAction::make()->iconButton(), EditAction::make()->iconButton(), DeleteAction::make()->iconButton()])
            ->bulkActions([BulkActionGroup::make([DeleteBulkAction::make()])]);
    }
}
