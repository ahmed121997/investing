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
            ->label(__('app.price_update_details'))
            ->hidden(fn (ListTrades $livewire): bool => $livewire->stockPriceUpdateResult === null)
            ->modalHeading(__('app.stock_price_update_details'))
            ->modalSubmitAction(false)
            ->modalCancelActionLabel(__('app.close'))
            ->extraModalFooterActions([
                Action::make('closeAndReloadStockPriceUpdateDetails')
                    ->label(__('app.close_and_reload'))
                    ->icon('heroicon-o-arrow-path')
                    ->color('gray')
                    ->action(fn (ListTrades $livewire) => $livewire->redirect(TradeResource::getUrl('index'), navigate: false)),
            ])
            ->modalWidth(Width::ScreenSmall)
            ->modalContent(fn (ListTrades $livewire) => view('filament.resources.trades.actions.stock-price-update-details', [
                'result' => $livewire->stockPriceUpdateResult,
            ]));
    }
}
