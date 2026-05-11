<?php

namespace App\Filament\Resources\Trades\Actions;

use App\Filament\Resources\Trades\Pages\ListTrades;
use App\Filament\Resources\Trades\TradeResource;
use Filament\Actions\Action;
use Filament\Support\Enums\Width;

class StockPriceUpdateDetailsAction
{
    public static function make(): Action
    {
        return Action::make('stockPriceUpdateDetails')
            ->label('Price Update Details')
            ->hidden(fn (ListTrades $livewire): bool => $livewire->stockPriceUpdateResult === null)
            ->modalHeading('Stock price update details')
            ->modalSubmitAction(false)
            ->modalCancelActionLabel('Close')
            ->extraModalFooterActions([
                Action::make('closeAndReloadStockPriceUpdateDetails')
                    ->label('Close and reload')
                    ->icon('heroicon-o-arrow-path')
                    ->color('gray')
                    ->action(fn (ListTrades $livewire) => $livewire->redirect(TradeResource::getUrl('index'), navigate: false)),
            ])
            ->modalWidth(Width::ScreenLarge)
            ->modalContent(fn (ListTrades $livewire) => view('filament.resources.trades.actions.stock-price-update-details', [
                'result' => $livewire->stockPriceUpdateResult,
            ]));
    }
}
