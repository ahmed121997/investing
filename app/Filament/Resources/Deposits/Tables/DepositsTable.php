<?php

namespace App\Filament\Resources\Deposits\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class DepositsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name')
                    ->label(__('app.user'))
                    ->searchable(),
                TextColumn::make('amount')
                    ->label(__('app.amount'))
                    ->money('USD')
                    ->sortable(),
                TextColumn::make('deposit_date')
                    ->label(__('app.deposit_date'))
                    ->date()
                    ->sortable(),
                TextColumn::make('description')
                    ->label(__('app.description'))
                    ->limit(50),
            ])
            ->filters([
                //
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
