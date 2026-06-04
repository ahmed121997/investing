<?php

namespace App\Filament\Resources\Stocks\Schemas;

use App\Models\Sector;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Schemas\Schema;

class StockForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Name')
                    ->required()
                    ->maxLength(255),
                TextInput::make('code')
                    ->label('Code')
                    ->required()
                    ->maxLength(255)
                    ->unique(ignoreRecord: true),
                TextInput::make('market')
                    ->label('Market')
                    ->default('EGX')
                    ->required()
                    ->maxLength(255),
                TextInput::make('price')
                    ->label('Price')
                    ->numeric()
                    ->required()
                    ->step(0.01),
                Select::make('sector_id')
                    ->label('Sector')
                    ->options(Sector::pluck('name_ar', 'id'))
                    ->searchable()
                    ->preload(),
            ]);
    }
}

