<?php

namespace App\Filament\Resources\Trades\Actions;

use App\Filament\Resources\Trades\Pages\ListTrades;
use App\Models\Stock;
use Filament\Actions\Action;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Illuminate\Support\Facades\File;

class RunStockPriceUpdateAction
{
    public static function make(): Action
    {
        return Action::make('runStockPriceUpdate')
            ->label(fn (): string => self::labelWithLastRunDateTime())
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
            ->action(
                function (array $data, ListTrades $livewire): void {
                    $livewire->startStockPriceUpdate($data);
                },
            );
    }

    private static function labelWithLastRunDateTime(): string
    {
        $lastRunDateTime = self::lastRunDateTime();

        if ($lastRunDateTime === null) {
            return 'Run Command';
        }

        return "Run Command ({$lastRunDateTime})";
    }

    private static function lastRunDateTime(): ?string
    {
        $directory = storage_path('app/stock-price-updates');
        $lastRunPath = "{$directory}/last-run-at.txt";

        if (! File::isDirectory($directory)) {
            return null;
        }

        if (File::exists($lastRunPath)) {
            return trim(File::get($lastRunPath)) ?: null;
        }

        $files = File::glob("{$directory}/*.{log,status}", GLOB_BRACE);

        if (empty($files)) {
            return null;
        }

        $lastModified = max(array_map(fn (string $path): int => File::lastModified($path), $files));
        return now()->setTimestamp($lastModified)->format('d-m-Y h:i:s a');
    }
}
