<?php

namespace App\Filament\Resources\Trades\RelationManagers;

use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class TradeTracksRelationManager extends RelationManager
{
    protected static string $relationship = 'tradeTracks';

    protected static ?string $recordTitleAttribute = 'id';

    public function isReadOnly(): bool
    {
        return false;
    }
    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('amount')
                    ->label('Amount')
                    ->numeric()
                    ->required()
                    ->step(0.01),
                DateTimePicker::make('date')
                    ->label('Date')
                    ->default(now())
                    ->native(false)
                    ->required(),
                Select::make('type')
                    ->label('Type')
                    ->native(false)
                    ->options([
                        'buy' => 'Buy',
                        'sell' => 'Sell',
                        'profit' => 'Profit',
                    ]),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label('ID')
                    ->sortable(),
                TextColumn::make('amount')
                    ->label('Amount')
                    ->numeric(decimalPlaces: 2)
                    ->sortable(),
                TextColumn::make('date')
                    ->label('Date')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('type')
                    ->label('Type')
                    ->sortable(),
            ])
            ->headerActions([
                CreateAction::make(),
            ])
            ->recordActions([
                EditAction::make()->iconButton(),
                DeleteAction::make()->iconButton(),
            ])
            ->bulkActions([
                DeleteBulkAction::make(),
            ]);
    }
}
