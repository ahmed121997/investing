<?php

namespace App\Filament\Resources\Sectors\Tables;

use Filament\Tables\Table;
use Filament\Support\Enums\Alignment;
use Filament\Tables\Columns\TextColumn;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
class SectorsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label(__('app.name_en'))
                    ->searchable()
                    ->sortable()
                    ->alignment(Alignment::Center),
                TextColumn::make('name_ar')
                    ->label(__('app.name_ar'))
                    ->searchable()
                    ->sortable()
                    ->alignment(Alignment::Center),
                TextColumn::make('stocks_count')
                    ->label(__('app.number_of_stocks'))
                    ->counts('stocks')
                    ->sortable()
                    ->alignment(Alignment::Center),
            ])
            ->filters([
                //
            ])
            ->actions([
                EditAction::make()->iconButton(),
                DeleteAction::make()->iconButton(),
            ])
            ->bulkActions([
                //
            ]);
    }
}
