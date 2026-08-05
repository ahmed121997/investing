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
                    ->label(__('app.stock'))
                    ->options(Stock::all()->mapWithKeys(fn ($stock) => [$stock->id => "{$stock->name} ({$stock->code})"]))
                    ->required()
                    ->searchable(),
                TextInput::make('amount')
                    ->label(__('app.amount'))
                    ->numeric()
                    ->default(0),
                Select::make('year')
                    ->label(__('app.year'))
                    ->native(false)
                    ->options(fn (): array => self::yearOptions())
                    ->default((int) now()->year)
                    ->required(),
                Select::make('status')
                    ->label(__('app.status'))
                    ->native(false)
                    ->options([
                        'open' => __('app.open'),
                        'close' => __('app.close'),
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
