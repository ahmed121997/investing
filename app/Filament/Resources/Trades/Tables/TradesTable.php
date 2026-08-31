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
use Filament\Support\Enums\Alignment;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ViewColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\HtmlString;
use Illuminate\Validation\ValidationException;

class TradesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ViewColumn::make('stock.name')
                    ->view('filament.resources.trades.tables.stock-name-column')
                    ->label(__('app.stock'))
                    ->sortable()
                    ->searchable(['name', 'code']),
                TextColumn::make('amount')
                    ->label(__('app.amount'))
                    ->numeric(decimalPlaces: 0)
                    ->sortable()
                    ->alignment(Alignment::Center),
                TextColumn::make('current_total')
                    ->formatStateUsing(fn ($state, $record): HtmlString => new HtmlString(
                        e(number_format((float) $state, 2))
                        .' (<span style="color: #10b981;">'
                        .e($record->stock?->price)
                        .'</span>)',
                    ))->html()
                    ->label(__('app.current_total'))
                    ->alignment(Alignment::Center),
                TextColumn::make('total_trades_amount')
                    ->label(__('app.trades_amount'))
                    ->numeric(decimalPlaces: 2)
                    ->sortable(query: fn (Builder $query, string $direction): Builder => $query
                        ->orderByRaw(self::totalTradesAmountExpression()." {$direction}"))
                    ->alignment(Alignment::Center),
                TextColumn::make('profit_loss')
                    ->label(__('app.profit_loss'))
                    ->numeric(decimalPlaces: 2)
                    ->sortable(query: fn (Builder $query, string $direction): Builder => $query
                        ->orderByRaw(self::profitLossExpression()." {$direction}"))
                    ->color(fn (mixed $state): string => match (true) {
                        $state > 0 => 'success',
                        $state < 0 => 'danger',
                        default => 'primary',
                    })
                    ->alignment(Alignment::Center),
                TextColumn::make('status')
                    ->label(__('app.status'))
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'open' => 'success',
                        'close' => 'danger',
                    })
                    ->sortable()
                    ->alignment(Alignment::Center)
                    ->extraAttributes([
                        'class' => 'flex justify-center',
                        'style' => 'min-width: 80px;',
                    ]),
                TextColumn::make('created_at')
                    ->label(__('app.created'))
                    ->dateTime('M d, Y')
                    ->sortable()
                    ->alignment(Alignment::Center),
            ])
            ->modifyQueryUsing(fn (Builder $query): Builder => $query->with('stock.sector'))
            ->defaultSort(fn (Builder $query): Builder => $query
                ->orderByRaw(self::profitLossExpression().' desc'))
            ->filters([
                SelectFilter::make('status')
                    ->label(__('app.status'))
                    ->native(false)
                    ->default('open')
                    ->options([
                        'open' => __('app.open'),
                        'close' => __('app.close'),
                    ]),
                SelectFilter::make('year')
                    ->label(__('app.year'))
                    ->native(false)
                    ->options(fn (): array => self::yearOptions()),
                SelectFilter::make('profit_loss_status')
                    ->label(__('app.result'))
                    ->native(false)
                    ->options([
                        'win' => __('app.win'),
                        'loss' => __('app.loss'),
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
                    ->label(__('app.add_track'))
                    ->modalHeading(fn (Trade $record): string => __('app.add_track_for', ['code' => $record->stock?->code]))
                    ->icon('heroicon-o-plus')
                    ->color('success')
                    ->form([
                        TextInput::make('amount')
                            ->label(__('app.amount'))
                            ->numeric()
                            ->required()
                            ->step(0.01),
                        DateTimePicker::make('date')
                            ->label(__('app.date'))
                            ->default(now())
                            ->required(),
                        Select::make('type')
                            ->label(__('app.type'))
                            ->native(false)
                            ->required()
                            ->options([
                                'buy' => __('app.buy'),
                                'sell' => __('app.sell'),
                                'profit' => __('app.profit'),
                            ]),
                    ])
                    ->action(function ($record, array $data) {
                        try {
                            $record->tradeTracks()->create($data);

                            Notification::make()
                                ->title(__('app.trade_track_created_success'))
                                ->success()
                                ->send();
                        } catch (ValidationException $exception) {
                            $message = collect($exception->errors())->flatten(1)->first() ?? __('app.invalid_trade_track_type');

                            Notification::make()
                                ->title($message)
                                ->danger()
                                ->send();

                            throw $exception;
                        }
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
