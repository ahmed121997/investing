<?php

namespace App\Filament\Resources\Trades\RelationManagers;

use Filament\Actions\Action;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\Indicator;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;

class TradeTracksRelationManager extends RelationManager
{
    protected static string $relationship = 'tradeTracks';

    protected static ?string $recordTitleAttribute = 'id';

    public function isReadOnly(): bool
    {
        return false;
    }

    public static function getModelLabel(): string
    {
        return __('app.trade_track');
    }

    public static function getPluralModelLabel(): string
    {
        return __('app.trade_tracks');
    }

    // title of table
    public static function getRelationshipTitle(): string
    {
        return __('app.trade_tracks');
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('amount')
                    ->label(__('app.amount'))
                    ->numeric()
                    ->required()
                    ->step(0.01),
                DateTimePicker::make('date')
                    ->label(__('app.date'))
                    ->default(now())
                    ->native(false)
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
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('date')
                    ->label(__('app.date'))
                    ->dateTime('M d, Y h:i a')
                    ->sortable(),
                TextColumn::make('amount')
                    ->label(__('app.amount'))
                    ->numeric(decimalPlaces: 2)
                    ->sortable(),

                TextColumn::make('type')
                    ->label(__('app.type'))
                    ->formatStateUsing(fn (?string $state): string => $state ? __('app.'.$state) : '-')
                    ->sortable(),
            ])
            ->filters([
                Filter::make('date')
                    ->label(__('app.date_range'))
                    ->schema([
                        DatePicker::make('from')
                            ->label(__('app.from'))
                            ->native(false),
                        DatePicker::make('until')
                            ->label(__('app.until'))
                            ->native(false),
                    ])
                    ->query(fn (Builder $query, array $data): Builder => $query
                        ->when(
                            $data['from'] ?? null,
                            fn (Builder $query, string $date): Builder => $query->whereDate('date', '>=', $date),
                        )
                        ->when(
                            $data['until'] ?? null,
                            fn (Builder $query, string $date): Builder => $query->whereDate('date', '<=', $date),
                        ))
                    ->indicateUsing(function (array $data): array {
                        $indicators = [];

                        if ($data['from'] ?? null) {
                            $indicators[] = Indicator::make(__('app.from_date', ['date' => Carbon::parse($data['from'])->toFormattedDateString()]))
                                ->removeField('from');
                        }

                        if ($data['until'] ?? null) {
                            $indicators[] = Indicator::make(__('app.until_date', ['date' => Carbon::parse($data['until'])->toFormattedDateString()]))
                                ->removeField('until');
                        }

                        return $indicators;
                    }),
            ])
            ->headerActions([
                Action::make('totalAmount')
                    ->label(fn (): string => __('app.total_with_value', ['value' => number_format((float) $this->getFilteredTableQuery()?->sum('amount'), 2)]))
                    ->badge()
                    ->color('success')
                    ->disabled(),
                CreateAction::make(),
            ])
            ->recordActions([
                EditAction::make()->iconButton(),
                DeleteAction::make()->iconButton(),
            ])
            ->bulkActions([
                DeleteBulkAction::make(),
            ]);
    }
}
