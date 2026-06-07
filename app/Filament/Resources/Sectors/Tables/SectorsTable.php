<?php

namespace App\Filament\Resources\Sectors\Tables;

use Filament\Tables\Table;
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
                    ->label('Name (English)')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('name_ar')
                    ->label('Name (Arabic)')
                    ->searchable()
                    ->sortable(),
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
