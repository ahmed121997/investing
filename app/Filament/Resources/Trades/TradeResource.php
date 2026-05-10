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

    public static function form(Schema $schema): Schema
    {
        return TradeForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([
                Section::make('Trade Details')
                    ->columns(2)
                    ->schema([
                        TextEntry::make('stock.name')
                            ->label('Stock')
                            ->formatStateUsing(fn ($state, $record) => $record->stock->name . ' (' . $record->stock->code . ')'),
                        TextEntry::make('amount')
                            ->label('Amount')
                            ->numeric(decimalPlaces: 0),
                        TextEntry::make('current_total')
                            ->label('Current Total')
                            ->numeric(decimalPlaces: 2),
                        TextEntry::make('total_trades_amount')
                            ->label('Total Trades Amount')
                            ->numeric(decimalPlaces: 2),
                        TextEntry::make('profit_loss')
                            ->label('Profit/Loss')
                            ->numeric(decimalPlaces: 2)
                            ->color(fn (mixed $state): string => match (true) {
                                $state > 0 => 'success',
                                $state < 0 => 'danger',
                                default => 'primary',
                            }),
                        TextEntry::make('status')
                            ->label('Status')
                            ->badge()
                            ->color(fn (string $state): string => match ($state) {
                                'open' => 'success',
                                'close' => 'danger',
                                default => 'primary',
                            }),
                        TextEntry::make('created_at')
                            ->label('Created')
                            ->dateTime(),
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
