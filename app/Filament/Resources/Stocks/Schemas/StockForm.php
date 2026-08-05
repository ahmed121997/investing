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
                    ->label(__('app.name'))
                    ->required()
                    ->maxLength(255),
                TextInput::make('code')
                    ->label(__('app.code'))
                    ->required()
                    ->maxLength(255)
                    ->unique(ignoreRecord: true),
                TextInput::make('market')
                    ->label(__('app.market'))
                    ->default('EGX')
                    ->required()
                    ->maxLength(255),
                TextInput::make('price')
                    ->label(__('app.price'))
                    ->numeric()
                    ->required()
                    ->step(0.001),
                Select::make('sector_id')
                    ->label(__('app.sector'))
                    ->options(Sector::pluck('name_ar', 'id'))
                    ->searchable()
                    ->preload(),
            ]);
    }
}

