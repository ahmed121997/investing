<?php

namespace App\Filament\Resources\Stocks;

use App\Filament\Resources\Stocks\Pages\ListStocks;
use App\Filament\Resources\Stocks\Pages\ViewStock;
use App\Filament\Resources\Stocks\RelationManagers\TradesRelationManager;
use App\Filament\Resources\Stocks\Schemas\StockForm;
use App\Filament\Resources\Stocks\Tables\StocksTable;
use App\Models\Stock;
use BackedEnum;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables\Table;

class StockResource extends Resource
{
    protected static ?string $model = Stock::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-chart-bar-square';

    public static function getNavigationSort(): ?int
    {
        return 4;
    }
    public static function getNavigationLabel(): string
    {
        return __('app.stocks');
    }

    public static function getModelLabel(): string
    {
        return __('app.stock');
    }

    public static function getPluralModelLabel(): string
    {
        return __('app.stocks');
    }

    public static function form(Schema $schema): Schema
    {
        return StockForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([
                Section::make(__('app.stock_details'))
                    ->columns(2)
                    ->schema([
                        TextEntry::make('name')
                            ->label(__('app.name')),
                        TextEntry::make('code')
                            ->label(__('app.code'))
                            ->badge()
                            ->color('primary'),
                        TextEntry::make('sector.name_ar')
                            ->label(__('app.sector')),
                        TextEntry::make('market')
                            ->label(__('app.market')),
                        TextEntry::make('price')
                            ->label(__('app.price'))
                            ->numeric(decimalPlaces: 3),
                        TextEntry::make('created_at')
                            ->label(__('app.created'))
                            ->dateTime('l, M d, Y h:i a'),
                        TextEntry::make('updated_at')
                            ->label(__('app.updated'))
                            ->dateTime('l, M d, Y h:i a'),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return StocksTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            TradesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListStocks::route('/'),
            'view' => ViewStock::route('/{record}'),
        ];
    }
}
