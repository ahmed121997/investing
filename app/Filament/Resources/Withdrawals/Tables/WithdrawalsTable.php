<?php

namespace App\Filament\Resources\Withdrawals\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Support\Enums\Alignment;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class WithdrawalsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('amount')
                    ->label(__('app.amount'))
                    ->money('EGP')
                    ->sortable()
                    ->alignment(Alignment::Center),
                TextColumn::make('withdrawal_date')
                    ->label(__('app.withdrawal_date'))
                    ->date()
                    ->sortable()
                    ->alignment(Alignment::Center),
                TextColumn::make('description')
                    ->label(__('app.description'))
                    ->limit(50)
                    ->alignment(Alignment::Center),
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
