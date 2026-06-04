<?php

namespace App\Filament\Resources\Sectors\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;

class SectorForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Section::make('Sector Information')
                    ->schema([
                        TextInput::make('name')
                            ->label('Name (English)')
                            ->required()
                            ->maxLength(255)
                            ->unique(ignoreRecord: true),
                        TextInput::make('name_ar')
                            ->label('Name (Arabic) - الاسم بالعربية')
                            ->required()
                            ->maxLength(255)
                            ->unique(ignoreRecord: true),
                    ]),
            ]);
    }
}
