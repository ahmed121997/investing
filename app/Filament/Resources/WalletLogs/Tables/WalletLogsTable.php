<?php

namespace App\Filament\Resources\WalletLogs\Tables;

use Filament\Support\Enums\Alignment;
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
                    ->dateTime(format: 'Y-m-d h:iA')
                    ->sortable()
                    ->alignment(Alignment::Center),
                TextColumn::make('action')
                    ->label(__('app.action'))
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => __('app.wallet_log_actions.'.$state))
                    ->color(fn (string $state): string => match ($state) {
                        'created' => 'success',
                        'updated' => 'warning',
                        'deleted' => 'danger',
                        'transferred' => 'info',
                    })
                    ->alignment(Alignment::Center),
                TextColumn::make('transaction_type')
                    ->label(__('app.type'))
                    ->badge()
                    ->formatStateUsing(fn (?string $state): string => $state ? __('app.'.$state) : '-')
                    ->alignment(Alignment::Center),
                TextColumn::make('amount')
                    ->label(__('app.amount').' / '.__('app.cash_change'))
                    ->formatStateUsing(function ($state, $record): string {
                        $cashChange = (float) $record->cash_change;
                        $changeClasses = match (true) {
                            $cashChange > 0 => 'bg-success-50 text-success-700 ring-success-600/20 dark:bg-success-500/10 dark:text-success-400',
                            $cashChange < 0 => 'bg-danger-50 text-danger-700 ring-danger-600/20 dark:bg-danger-500/10 dark:text-danger-400',
                            default => 'bg-gray-50 text-gray-700 ring-gray-600/20 dark:bg-white/10 dark:text-gray-400',
                        };
                        $changePrefix = $cashChange > 0 ? '+' : '';

                        return sprintf(
                            '<div class="flex flex-wrap items-center gap-1.5 whitespace-nowrap"><span class="inline-flex items-center justify-center rounded-md bg-primary-50 px-2 py-1 text-xs font-semibold text-primary-700 ring-1 ring-inset ring-primary-700/10 dark:bg-primary-500/10 dark:text-primary-400" style="min-width: 80px;">%s</span><span class="inline-flex items-center justify-center rounded-md px-2 py-1 text-xs font-semibold ring-1 ring-inset %s" style="min-width: 80px;">%s%s</span></div>',
                            number_format((float) $state, 2),
                            $changeClasses,
                            $changePrefix,
                            number_format($cashChange, 2),
                        );
                    })
                    ->html()
                    ->alignment(Alignment::Center),
                TextColumn::make('cash_before')
                    ->label(__('app.dashboard.total_cash'))
                    ->formatStateUsing(function ($state, $record): string {
                        return sprintf(
                            '<div class="flex items-center gap-1.5 whitespace-nowrap"><span class="inline-flex items-center justify-center rounded-md bg-gray-50 px-2 py-1 text-xs font-medium text-gray-700 ring-1 ring-inset ring-gray-600/20 dark:bg-white/10 dark:text-gray-300" style="min-width: 80px;">%s</span><span class="text-primary-500">→</span><span class="inline-flex items-center justify-center rounded-md bg-primary-50 px-2 py-1 text-xs font-semibold text-primary-700 ring-1 ring-inset ring-primary-700/10 dark:bg-primary-500/10 dark:text-primary-400" style="min-width: 80px;">%s</span></div>',
                            number_format((float) $state, 2),
                            number_format((float) $record->cash_after, 2),
                        );
                    })
                    ->html()
                    ->alignment(Alignment::Center),
                TextColumn::make('save_cloud_before')
                    ->label(__('app.dashboard.total_save_cloud'))
                    ->formatStateUsing(function ($state, $record): string {
                        if ($state === null || $record->save_cloud_after === null) {
                            return '<span class="text-gray-400 dark:text-gray-500">—</span>';
                        }

                        return sprintf(
                            '<div class="flex items-center gap-1.5 whitespace-nowrap"><span class="inline-flex items-center justify-center rounded-md bg-gray-50 px-2 py-1 text-xs font-medium text-gray-700 ring-1 ring-inset ring-gray-600/20 dark:bg-white/10 dark:text-gray-300" style="min-width: 80px;">%s</span><span class="text-primary-500">→</span><span class="inline-flex items-center justify-center rounded-md bg-primary-50 px-2 py-1 text-xs font-semibold text-primary-700 ring-1 ring-inset ring-primary-700/10 dark:bg-primary-500/10 dark:text-primary-400" style="min-width: 80px;">%s</span></div>',
                            number_format((float) $state, 2),
                            number_format((float) $record->save_cloud_after, 2),
                        );
                    })
                    ->html()
                    ->alignment(Alignment::Center),
                TextColumn::make('trade_track_id')
                    ->label(__('app.trade_track'))
                    ->formatStateUsing(fn ($record): string => $record->getStockCodeAttribute() ?? '-')
                    ->sortable()
                    ->placeholder('-')
                    ->alignment(Alignment::Center),
            ])
            ->filters([
                SelectFilter::make('action')
                    ->label(__('app.action'))
                    ->options([
                        'created' => __('app.wallet_log_actions.created'),
                        'updated' => __('app.wallet_log_actions.updated'),
                        'deleted' => __('app.wallet_log_actions.deleted'),
                        'transferred' => __('app.wallet_log_actions.transferred'),
                    ]),
                SelectFilter::make('transaction_type')
                    ->label(__('app.type'))
                    ->options([
                        'buy' => __('app.buy'),
                        'sell' => __('app.sell'),
                        'profit' => __('app.profit'),
                        'cash_to_save_cloud' => __('app.cash_to_save_cloud'),
                        'save_cloud_to_cash' => __('app.save_cloud_to_cash'),
                    ]),
            ]);
    }
}
