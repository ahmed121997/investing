<?php

namespace App\Filament\Resources\Trades\Actions;

use App\Filament\Resources\Trades\Pages\ListTrades;
use App\Models\Stock;
use Filament\Actions\Action;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\File;
use Throwable;

class RunStockPriceUpdateAction
{
    public static function make(): Action
    {
        return Action::make('runStockPriceUpdate')
            ->label(fn (): string => self::labelWithLastRunDateTime())
            ->icon('heroicon-o-arrow-path')
            ->color('info')
            ->modalHeading(__('app.run_stock_price_update'))
            ->modalDescription(__('app.run_stock_price_update_description'))
            ->modalSubmitActionLabel(__('app.run_command_button'))
            ->form([
                Select::make('provider')
                    ->label(__('app.provider'))
                    ->options([
                        'tradingview' => __('app.tradingview'),
                        'mubasher' => __('app.mubasher'),
                        'stooq' => __('app.stooq'),
                    ])
                    ->default('tradingview')
                    ->required()
                    ->native(false),
                TextInput::make('market')
                    ->label(__('app.market'))
                    ->placeholder(__('app.market_filter_placeholder')),
                Select::make('codes')
                    ->label(__('app.stock_codes'))
                    ->options(fn () => Stock::query()
                        ->orderBy('code')
                        ->pluck('code', 'code')
                        ->all())
                    ->multiple()
                    ->searchable()
                    ->preload(),
                TextInput::make('delay')
                    ->label(__('app.delay_between_requests'))
                    ->numeric()
                    ->default(250)
                    ->minValue(0)
                    ->required(),
                Toggle::make('dry_run')
                    ->label(__('app.dry_run'))
                    ->helperText(__('app.dry_run_helper')),
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
            return __('app.run_command');
        }

        return __('app.run_command_with_time', ['time' => $lastRunDateTime]);
    }

    private static function lastRunDateTime(): ?string
    {
        $directory = storage_path('app/stock-price-updates');
        $lastRunPath = "{$directory}/last-run-at.txt";

        if (! File::isDirectory($directory)) {
            return null;
        }

        if (File::exists($lastRunPath)) {
            return self::formatDateTime(trim(File::get($lastRunPath)));
        }

        $files = File::glob("{$directory}/*.{log,status}", GLOB_BRACE);

        if (empty($files)) {
            return null;
        }

        $lastModified = max(array_map(fn (string $path): int => File::lastModified($path), $files));

        return Carbon::createFromTimestamp($lastModified)->diffForHumans();
    }

    private static function formatDateTime(?string $dateTime): ?string
    {
        if (blank($dateTime)) {
            return null;
        }

        try {
            return Carbon::createFromFormat('d-m-Y h:i:s a', $dateTime)->diffForHumans();
        } catch (Throwable) {
            try {
                return Carbon::parse($dateTime)->diffForHumans();
            } catch (Throwable) {
                return $dateTime;
            }
        }
    }
}
