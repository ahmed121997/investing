<?php

namespace App\Filament\Resources\Stocks\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class StocksTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('code')
                    ->label('Code')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('sector.name_ar')
                    ->label('Sector')
                    ->searchable()
                    ->sortable(),
                // TextColumn::make('market')
                //     ->label('Market')
                //     ->searchable()
                //     ->sortable(),
                TextColumn::make('price')
                    ->label('Price')
                    ->sortable(),
                TextColumn::make('updated_at')
                    ->label('Last Updated')
                    ->dateTime('M d, Y h:i a')
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('sector_id')
                    ->label('Sector')
                    ->native(false)
                    ->searchable()
                    ->preload()
                    ->relationship('sector', 'name_ar'),
            ])
            ->recordActions([
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
