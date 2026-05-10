<?php

namespace App\Filament\Resources\Trades\Tables;

use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Support\Str;
use Filament\Tables\Table;

class TradesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('stock.name')
                    ->formatStateUsing(fn ($state, $record) => Str::limit($record->stock->name, 20, '...') . ' (' . $record->stock->code . ')')
                    ->label('Stock')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('amount')
                    ->label('Amount')
                    ->numeric(decimalPlaces: 0)
                    ->sortable(),
                TextColumn::make('current_total')
                    ->label('Current Total')
                    ->numeric(decimalPlaces: 2)
                    ->sortable(),
                TextColumn::make('total_trades_amount')
                    ->label('Total Trades Amount')
                    ->numeric(decimalPlaces: 2),
                TextColumn::make('profit_loss')
                    ->label('Profit/Loss')
                    ->numeric(decimalPlaces: 2)
                    ->color(fn (string $state): string => match (true) {
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
                    ->dateTime()
                    ->sortable(),
            ])
            ->defaultSort('status', 'asc')
            ->filters([
                SelectFilter::make('status')
                    ->native(false)
                    ->options([
                        'open' => 'Open',
                        'close' => 'Close',
                    ]),
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
}
