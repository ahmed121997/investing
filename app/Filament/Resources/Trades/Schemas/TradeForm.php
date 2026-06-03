<?php

namespace App\Filament\Resources\Trades\Schemas;

use App\Models\Stock;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class TradeForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('stock_id')
                    ->label('Stock')
                    ->options(Stock::all()->mapWithKeys(fn ($stock) => [$stock->id => "{$stock->name} ({$stock->code})"]))
                    ->required()
                    ->searchable(),
                TextInput::make('amount')
                    ->label('Amount')
                    ->numeric()
                    ->default(0),
                Select::make('year')
                    ->label('Year')
                    ->native(false)
                    ->options(fn (): array => self::yearOptions())
                    ->default((int) now()->year)
                    ->required(),
                Select::make('status')
                    ->label('Status')
                    ->native(false)
                    ->options([
                        'open' => 'Open',
                        'close' => 'Close',
                    ])
                    ->default('open')
                    ->required(),
            ]);
    }

    private static function yearOptions(): array
    {
        $currentYear = (int) now()->year;

        return collect(range($currentYear + 1, $currentYear - 10))
            ->mapWithKeys(fn (int $year): array => [$year => (string) $year])
            ->all();
    }
}
