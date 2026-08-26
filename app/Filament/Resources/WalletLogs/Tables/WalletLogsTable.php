<?php

namespace App\Filament\Resources\WalletLogs\Tables;

use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class WalletLogsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->defaultSort('created_at', 'desc')
            ->columns([
                TextColumn::make('created_at')
                    ->label(__('app.date'))
                    ->dateTime('M d, Y h:i a')
                    ->sortable(),
                TextColumn::make('wallet.user.name')
                    ->label(__('app.user'))
                    ->searchable(),
                TextColumn::make('action')
                    ->label(__('app.action'))
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => __('app.wallet_log_actions.'.$state))
                    ->color(fn (string $state): string => match ($state) {
                        'created' => 'success',
                        'updated' => 'warning',
                        'deleted' => 'danger',
                    }),
                TextColumn::make('transaction_type')
                    ->label(__('app.type'))
                    ->badge()
                    ->formatStateUsing(fn (?string $state): string => $state ? __('app.'.$state) : '-'),
                TextColumn::make('amount')
                    ->label(__('app.amount'))
                    ->numeric(decimalPlaces: 2)
                    ->sortable(),
                TextColumn::make('cash_change')
                    ->label(__('app.cash_change'))
                    ->numeric(decimalPlaces: 2)
                    ->prefix(fn (string $state): string => (float) $state > 0 ? '+' : '')
                    ->color(fn (string $state): string => match (true) {
                        (float) $state > 0 => 'success',
                        (float) $state < 0 => 'danger',
                        default => 'gray',
                    })
                    ->sortable(),
                TextColumn::make('cash_before')
                    ->label(__('app.cash_before'))
                    ->numeric(decimalPlaces: 2),
                TextColumn::make('cash_after')
                    ->label(__('app.cash_after'))
                    ->numeric(decimalPlaces: 2),
                TextColumn::make('trade_track_id')
                    ->label(__('app.trade_track'))
                    ->placeholder('-'),
            ])
            ->filters([
                SelectFilter::make('action')
                    ->label(__('app.action'))
                    ->options([
                        'created' => __('app.wallet_log_actions.created'),
                        'updated' => __('app.wallet_log_actions.updated'),
                        'deleted' => __('app.wallet_log_actions.deleted'),
                    ]),
                SelectFilter::make('transaction_type')
                    ->label(__('app.type'))
                    ->options([
                        'buy' => __('app.buy'),
                        'sell' => __('app.sell'),
                        'profit' => __('app.profit'),
                    ]),
            ]);
    }
}
