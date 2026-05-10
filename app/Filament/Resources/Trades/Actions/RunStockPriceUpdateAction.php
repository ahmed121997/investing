<?php

namespace App\Filament\Resources\Trades\Actions;

use App\Filament\Resources\Trades\Pages\ListTrades;
use App\Models\Stock;
use Filament\Actions\Action;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;

class RunStockPriceUpdateAction
{
    public static function make(): Action
    {
        return Action::make('runStockPriceUpdate')
            ->label('Run Price Update')
            ->icon('heroicon-o-arrow-path')
            ->color('info')
            ->modalHeading('Run stock price update')
            ->modalDescription('Runs the stocks:update-prices command and shows the command output while it runs.')
            ->modalSubmitActionLabel('Run command')
            ->form([
                Select::make('provider')
                    ->label('Provider')
                    ->options([
                        'tradingview' => 'TradingView',
                        'mubasher' => 'Mubasher',
                        'stooq' => 'Stooq',
                    ])
                    ->default('tradingview')
                    ->required()
                    ->native(false),
                TextInput::make('market')
                    ->label('Market')
                    ->placeholder('Optional market filter'),
                Select::make('codes')
                    ->label('Stock codes')
                    ->options(fn () => Stock::query()
                        ->orderBy('code')
                        ->pluck('code', 'code')
                        ->all())
                    ->multiple()
                    ->searchable()
                    ->preload(),
                TextInput::make('delay')
                    ->label('Delay between requests (ms)')
                    ->numeric()
                    ->default(250)
                    ->minValue(0)
                    ->required(),
                Toggle::make('dry_run')
                    ->label('Dry run')
                    ->helperText('Fetch and show prices without saving them.'),
            ])
            ->action(fn (array $data, ListTrades $livewire): mixed => $livewire->startStockPriceUpdate($data));
    }
}
