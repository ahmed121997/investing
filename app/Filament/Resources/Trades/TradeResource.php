<?php

namespace App\Filament\Resources\Trades;

use App\Filament\Resources\Trades\Pages\ListTrades;
use App\Filament\Resources\Trades\Pages\ViewTrade;
use App\Filament\Resources\Trades\RelationManagers\TradeTracksRelationManager;
use App\Filament\Resources\Trades\Schemas\TradeForm;
use App\Filament\Resources\Trades\Tables\TradesTable;
use App\Models\Trade;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;

class TradeResource extends Resource
{
    protected static ?string $model = Trade::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;


    public static function getNavigationSort(): ?int
    {
        return 5;
    }

    public static function getNavigationLabel(): string
    {
        return __('app.trades');
    }

    public static function getModelLabel(): string
    {
        return __('app.trade');
    }

    public static function getPluralModelLabel(): string
    {
        return __('app.trades');
    }

    public static function form(Schema $schema): Schema
    {
        return TradeForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([
                Section::make(__('app.trade_details'))
                    ->columns(2)
                    ->schema([
                        TextEntry::make('stock.name')
                            ->label(__('app.stock'))
                            ->formatStateUsing(fn ($state, $record) => $record->stock->name . ' (' . $record->stock->code . ')'),
                        TextEntry::make('amount')
                            ->label(__('app.amount'))
                            ->numeric(decimalPlaces: 0),
                        TextEntry::make('current_total')
                            ->label(__('app.current_total'))
                            ->numeric(decimalPlaces: 2),
                        TextEntry::make('total_trades_amount')
                            ->label(__('app.total_trades_amount'))
                            ->numeric(decimalPlaces: 2),
                        TextEntry::make('profit_loss')
                            ->label(__('app.profit_loss'))
                            ->numeric(decimalPlaces: 2)
                            ->color(fn (mixed $state): string => match (true) {
                                $state > 0 => 'success',
                                $state < 0 => 'danger',
                                default => 'primary',
                            }),
                        TextEntry::make('status')
                            ->label(__('app.status'))
                            ->formatStateUsing(fn (?string $state): string => $state ? __('app.'.$state) : '-')
                            ->placeholder('-')
                            ->badge()
                            ->color(fn (string $state): string => match ($state) {
                                'open' => 'success',
                                'close' => 'danger',
                                default => 'primary',
                            }),
                        TextEntry::make('closed_at')
                            ->label(__('app.closed_at'))
                            ->dateTime('M d, Y h:i a')
                            ->placeholder('-'),
                        TextEntry::make('days_open')
                            ->label(__('app.days_open'))
                            ->placeholder('-'),
                        TextEntry::make('number_of_trades')
                            ->label(__('app.number_of_trades'))
                            ->state(fn ($record) => $record->tradeTracks->count())
                            ->badge()
                            ->numeric(decimalPlaces: 0),
                        TextEntry::make('created_at')
                            ->label(__('app.created'))
                            ->dateTime('M d, Y h:i a'),
                        TextEntry::make('updated_at')
                            ->label(__('app.updated'))
                            ->dateTime('M d, Y h:i a'),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return TradesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            TradeTracksRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListTrades::route('/'),
            'view' => ViewTrade::route('/{record}'),
        ];
    }
}
