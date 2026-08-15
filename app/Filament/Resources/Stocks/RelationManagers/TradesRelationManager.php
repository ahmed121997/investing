<?php

namespace App\Filament\Resources\Stocks\RelationManagers;

use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class TradesRelationManager extends RelationManager
{
    protected static string $relationship = 'trades';

    protected static ?string $recordTitleAttribute = 'id';

    public function isReadOnly(): bool
    {
        return false;
    }

    public static function getModelLabel(): string
    {
        return __('app.trade');
    }

    public static function getPluralModelLabel(): string
    {
        return __('app.trades');
    }

    public static function getRelationshipTitle(): string
    {
        return __('app.trades');
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('created_at')
                    ->label(__('app.created'))
                    ->dateTime('M d, Y h:i a')
                    ->sortable(),
                TextColumn::make('year')
                    ->label(__('app.year'))
                    ->sortable(),
                TextColumn::make('amount')
                    ->label(__('app.amount'))
                    ->numeric(decimalPlaces: 0)
                    ->sortable(),
                TextColumn::make('current_total')
                    ->label(__('app.current_total'))
                    ->numeric(decimalPlaces: 2)
                    ->sortable(),
                TextColumn::make('total_trades_amount')
                    ->label(__('app.total_trades_amount'))
                    ->numeric(decimalPlaces: 2)
                    ->sortable(),
                TextColumn::make('profit_loss')
                    ->label(__('app.profit_loss'))
                    ->numeric(decimalPlaces: 2)
                    ->sortable(query: fn (Builder $query, string $direction): Builder => $query
                        ->orderByRaw(self::profitLossExpression()." {$direction}"))
                    ->color(fn (mixed $state): string => match (true) {
                        $state > 0 => 'success',
                        $state < 0 => 'danger',
                        default => 'primary',
                    }),
                TextColumn::make('status')
                    ->label(__('app.status'))
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'open' => 'success',
                        'close' => 'danger',
                        default => 'primary',
                    })
                    ->sortable(),
            ])
            ->defaultSort(fn (Builder $query): Builder => $query
                ->orderByRaw(self::profitLossExpression().' desc'));
    }

    private static function profitLossExpression(): string
    {
        return '(
            trades.amount * (
                SELECT stocks.price
                FROM stocks
                WHERE stocks.id = trades.stock_id
            )
        ) + COALESCE((
            SELECT SUM(trade_tracks.amount)
            FROM trade_tracks
            WHERE trade_tracks.trade_id = trades.id
        ), 0)';
    }
}
