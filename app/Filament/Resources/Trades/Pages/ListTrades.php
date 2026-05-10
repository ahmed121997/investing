<?php

namespace App\Filament\Resources\Trades\Pages;

use App\Filament\Resources\Trades\TradeResource;
use App\Models\Stock;
use Filament\Actions\Action;
use Filament\Actions\CreateAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ListRecords;

class ListTrades extends ListRecords
{
    protected static string $resource = TradeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
            Action::make('updateStockPrice')
                ->label('Update Stock Price')
                ->icon('heroicon-o-currency-dollar')
                ->color('success')
                ->form([
                    Select::make('stock_id')
                        ->label('Stock')
                        ->options(Stock::all()->mapWithKeys(fn ($stock) => [$stock->id => "{$stock->name} ({$stock->code})"]))
                        ->required()
                        ->searchable(),
                    TextInput::make('price')
                        ->label('New Price')
                        ->numeric()
                        ->required()
                        ->step(0.01),
                ])
                ->action(function (array $data) {
                    $stock = Stock::find($data['stock_id']);
                    $stock->update(['price' => $data['price']]);

                    Notification::make()
                        ->title('Stock price updated successfully')
                        ->success()
                        ->send();
                }),
        ];
    }
}
