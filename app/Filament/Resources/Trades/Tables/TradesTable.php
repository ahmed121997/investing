<?php

namespace App\Filament\Resources\Trades\Tables;

use App\Models\Trade;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\HtmlString;
use Illuminate\Support\Str;

class TradesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('stock.name')
                    ->formatStateUsing(fn ($state, $record): HtmlString => new HtmlString(
                        e(Str::limit($state, 15, '...'))
                        .' ('.e($record->stock->code).') '
                        .'<span style="display: inline-flex; align-items: center; background-color: #dcfce7; color: #166534; padding: 0.125rem 0.375rem;border-radius: 9999px; font-size: 0.65rem; font-weight: 400; line-height: 1;">'
                        .e($record->year)
                        .'</span>',
                    ))->html()
                    ->label('Stock')
                    ->sortable()
                    ->searchable(['name', 'code']),
                TextColumn::make('amount')
                    ->label('Amount')
                    ->numeric(decimalPlaces: 0)
                    ->sortable(),
                TextColumn::make('current_total')
                    ->formatStateUsing(fn ($state, $record): HtmlString => new HtmlString(
                        e(number_format((float) $state, 2))
                        .' (<span style="color: #10b981;">'
                        .e($record->stock?->price)
                        .'</span>)',
                    ))->html()
                    ->label('Current Total'),
                TextColumn::make('total_trades_amount')
                    ->label('Trades Amount')
                    ->numeric(decimalPlaces: 2)
                    ->sortable(query: fn (Builder $query, string $direction): Builder => $query
                        ->orderByRaw(self::totalTradesAmountExpression()." {$direction}")),
                TextColumn::make('profit_loss')
                    ->label('Profit/Loss')
                    ->numeric(decimalPlaces: 2)
                    ->sortable(query: fn (Builder $query, string $direction): Builder => $query
                        ->orderByRaw(self::profitLossExpression()." {$direction}"))
                    ->color(fn (mixed $state): string => match (true) {
                        $state > 0 => 'success',
                        $state < 0 => 'danger',
                        default => 'primary',
                    }),
                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'open' => 'success',
                        'close' => 'danger',
                    })
                    ->sortable(),
                TextColumn::make('created_at')
                    ->label('Created')
                    ->dateTime('M d, Y')
                    ->sortable(),
            ])
            ->defaultSort(fn (Builder $query): Builder => $query
                ->orderByRaw(self::profitLossExpression().' desc'))
            ->filters([
                SelectFilter::make('status')
                    ->native(false)
                    ->default('open')
                    ->options([
                        'open' => 'Open',
                        'close' => 'Close',
                    ]),
                SelectFilter::make('year')
                    ->label('Year')
                    ->native(false)
                    ->options(fn (): array => self::yearOptions()),
                SelectFilter::make('profit_loss_status')
                    ->label('Result')
                    ->native(false)
                    ->options([
                        'win' => 'Win',
                        'loss' => 'Loss',
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        $value = $data['value'] ?? null;

                        if (! in_array($value, ['win', 'loss'], true)) {
                            return $query;
                        }

                        return $query->whereRaw(self::profitLossExpression().($value === 'win' ? ' > 0' : ' < 0'));
                    }),
            ])
            ->recordActions([
                Action::make('addTradeTrack')
                    ->label('Add')
                    ->icon('heroicon-o-plus')
                    ->color('success')
                    ->form([
                        TextInput::make('amount')
                            ->label('Amount')
                            ->numeric()
                            ->required()
                            ->step(0.01),
                        DateTimePicker::make('date')
                            ->label('Date')
                            ->default(now())
                            ->required(),
                        Select::make('type')
                            ->label('Type')
                            ->native(false)
                            ->options([
                                'buy' => 'Buy',
                                'sell' => 'Sell',
                                'profit' => 'Profit',
                            ]),
                    ])
                    ->action(function ($record, array $data) {
                        $record->tradeTracks()->create($data);

                        Notification::make()
                            ->title('Trade track created successfully')
                            ->success()
                            ->send();
                    }),
                EditAction::make()->iconButton(),
                DeleteAction::make()->iconButton(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    private static function profitLossExpression(): string
    {
        return '(
            trades.amount * (
                SELECT stocks.price
                FROM stocks
                WHERE stocks.id = trades.stock_id
            )
        ) + '.self::totalTradesAmountExpression();
    }

    private static function totalTradesAmountExpression(): string
    {
        return 'COALESCE((
            SELECT SUM(trade_tracks.amount)
            FROM trade_tracks
            WHERE trade_tracks.trade_id = trades.id
        ), 0)';
    }

    private static function yearOptions(): array
    {
        $currentYear = (int) now()->year;

        $years = Trade::query()
            ->whereNotNull('year')
            ->distinct()
            ->orderByDesc('year')
            ->pluck('year')
            ->map(fn (int $year): int => $year)
            ->push($currentYear)
            ->unique()
            ->sortDesc();

        return $years
            ->mapWithKeys(fn (int $year): array => [(string) $year => (string) $year])
            ->all();
    }
}
