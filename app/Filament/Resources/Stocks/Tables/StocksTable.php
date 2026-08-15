<?php

namespace App\Filament\Resources\Stocks\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class StocksTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label(__('app.name'))
                    ->searchable()
                    ->sortable(),
                TextColumn::make('code')
                    ->label(__('app.code'))
                    ->searchable()
                    ->sortable(),
                TextColumn::make('sector.name_ar')
                    ->label(__('app.sector'))
                    ->searchable()
                    ->sortable(),
                // TextColumn::make('market')
                //     ->label('Market')
                //     ->searchable()
                //     ->sortable(),
                TextColumn::make('price')
                    ->label(__('app.price'))
                    ->sortable(),
                TextColumn::make('updated_at')
                    ->label(__('app.last_updated'))
                    ->dateTime('M d, Y h:i a')
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('sector_id')
                    ->label(__('app.sector'))
                    ->native(false)
                    ->searchable()
                    ->preload()
                    ->relationship('sector', 'name_ar'),
                SelectFilter::make('trade_status')
                    ->label(__('app.status'))
                    ->native(false)
                    ->options([
                        'open' => __('app.open'),
                        'close' => __('app.close'),
                    ])
                    ->query(fn (Builder $query, array $data): Builder => $query
                        ->when(
                            in_array($data['value'] ?? null, ['open', 'close'], true),
                            fn (Builder $query): Builder => $query
                                ->whereHas('trades', fn (Builder $q): Builder => $q->where('status', $data['value'])),
                        )),
            ])
            ->recordActions([
                ViewAction::make()->iconButton(),
                EditAction::make()->iconButton(),
                DeleteAction::make()->iconButton(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
