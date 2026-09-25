<?php

namespace App\Filament\Resources\Stocks;

use App\Filament\Concerns\HidesFromAdminNavigation;
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
    use HidesFromAdminNavigation;
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
                Section::make(__('app.price_increase'))
                    ->icon('heroicon-o-arrow-trending-up')
                    ->iconColor('success')
                    ->columns(4)
                    ->schema([
                        TextEntry::make('price_up_5')
                            ->label(__('app.price'))
                            ->state(fn (Stock $record): float => (float) $record->getRawOriginal('price') * 1.05)
                            ->numeric(decimalPlaces: fn (TextEntry $component): int => (float) $component->getState() < 1 ? 3 : 2, locale: 'en')
                            ->prefix(__('app.price_up_badge', ['percentage' => 5]) . ' ')
                            ->badge()
                            ->color('success'),
                        TextEntry::make('price_up_10')
                            ->label(__('app.price'))
                            ->state(fn (Stock $record): float => (float) $record->getRawOriginal('price') * 1.10)
                            ->numeric(decimalPlaces: fn (TextEntry $component): int => (float) $component->getState() < 1 ? 3 : 2, locale: 'en')
                            ->prefix(__('app.price_up_badge', ['percentage' => 10]) . ' ')
                            ->badge()
                            ->color('success'),
                        TextEntry::make('price_up_15')
                            ->label(__('app.price'))
                            ->state(fn (Stock $record): float => (float) $record->getRawOriginal('price') * 1.15)
                            ->numeric(decimalPlaces: fn (TextEntry $component): int => (float) $component->getState() < 1 ? 3 : 2, locale: 'en')
                            ->prefix(__('app.price_up_badge', ['percentage' => 15]) . ' ')
                            ->badge()
                            ->color('success'),
                        TextEntry::make('price_up_20')
                            ->label(__('app.price'))
                            ->state(fn (Stock $record): float => (float) $record->getRawOriginal('price') * 1.20)
                            ->numeric(decimalPlaces: fn (TextEntry $component): int => (float) $component->getState() < 1 ? 3 : 2, locale: 'en')
                            ->prefix(__('app.price_up_badge', ['percentage' => 20]) . ' ')
                            ->badge()
                            ->color('success'),
                    ]),
                Section::make(__('app.price_decrease'))
                    ->icon('heroicon-o-arrow-trending-down')
                    ->iconColor('danger')
                    ->columns(4)
                    ->schema([
                        TextEntry::make('price_down_5')
                            ->label(__('app.price'))
                            ->state(fn (Stock $record): float => (float) $record->getRawOriginal('price') * 0.95)
                            ->numeric(decimalPlaces: fn (TextEntry $component): int => (float) $component->getState() < 1 ? 3 : 2, locale: 'en')
                            ->prefix(__('app.price_down_badge', ['percentage' => 5]) . ' ')
                            ->badge()
                            ->color('danger'),
                        TextEntry::make('price_down_10')
                            ->label(__('app.price'))
                            ->state(fn (Stock $record): float => (float) $record->getRawOriginal('price') * 0.90)
                            ->numeric(decimalPlaces: fn (TextEntry $component): int => (float) $component->getState() < 1 ? 3 : 2, locale: 'en')
                            ->prefix(__('app.price_down_badge', ['percentage' => 10]) . ' ')
                            ->badge()
                            ->color('danger'),
                        TextEntry::make('price_down_15')
                            ->label(__('app.price'))
                            ->state(fn (Stock $record): float => (float) $record->getRawOriginal('price') * 0.85)
                            ->numeric(decimalPlaces: fn (TextEntry $component): int => (float) $component->getState() < 1 ? 3 : 2, locale: 'en')
                            ->prefix(__('app.price_down_badge', ['percentage' => 15]) . ' ')
                            ->badge()
                            ->color('danger'),
                        TextEntry::make('price_down_20')
                            ->label(__('app.price'))
                            ->state(fn (Stock $record): float => (float) $record->getRawOriginal('price') * 0.80)
                            ->numeric(decimalPlaces: fn (TextEntry $component): int => (float) $component->getState() < 1 ? 3 : 2, locale: 'en')
                            ->prefix(__('app.price_down_badge', ['percentage' => 20]) . ' ')
                            ->badge()
                            ->color('danger'),
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
