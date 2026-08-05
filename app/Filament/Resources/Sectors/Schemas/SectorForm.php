<?php

namespace App\Filament\Resources\Sectors\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;

class SectorForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Section::make(__('app.sector_information'))
                    ->columnSpan('full')
                    ->schema([
                        TextInput::make('name')
                            ->label(__('app.name_en'))
                            ->required()
                            ->maxLength(255)
                            ->unique(ignoreRecord: true),
                        TextInput::make('name_ar')
                            ->label(__('app.name_ar'))
                            ->required()
                            ->maxLength(255)
                            ->unique(ignoreRecord: true),
                    ]),
            ]);
    }
}
