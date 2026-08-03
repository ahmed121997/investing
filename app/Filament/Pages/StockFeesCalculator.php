<?php

namespace App\Filament\Pages;

use App\Services\StockFeesCalculationResult;
use App\Services\StockFeesCalculatorService;
use BackedEnum;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\TextInput;
use Filament\Pages\Page;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;

class StockFeesCalculator extends Page
{
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCalculator;

    protected static ?int $navigationSort = 1;

    protected string $view = 'filament.pages.stock-fees-calculator';

    public static function getNavigationLabel(): string
    {
        return __('app.stock_fees.calculator_page');
    }

    public static function getNavigationGroup(): string|\UnitEnum|null
    {
        return __('app.stock_fees.tools_group');
    }

    public function getTitle(): \Illuminate\Contracts\Support\Htmlable|string
    {
        return __('app.stock_fees.calculator_page');
    }

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill([
            'input_method' => StockFeesCalculatorService::INPUT_METHOD_TRADE_VALUE,
            'thunder_x' => StockFeesCalculatorService::THUNDER_X_NO,
            'settlement_type' => StockFeesCalculatorService::SETTLEMENT_T0,
        ]);
    }

    public function defaultForm(Schema $schema): Schema
    {
        return $schema->statePath('data');
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([
                Section::make(__('app.stock_fees.input_section'))
                    ->columns(2)
                    ->schema([
                        Radio::make('input_method')
                            ->label(__('app.stock_fees.input_method'))
                            ->options([
                                StockFeesCalculatorService::INPUT_METHOD_TRADE_VALUE => __('app.stock_fees.input_method_trade_value'),
                                StockFeesCalculatorService::INPUT_METHOD_QUANTITY => __('app.stock_fees.input_method_quantity'),
                            ])
                            ->default(StockFeesCalculatorService::INPUT_METHOD_TRADE_VALUE)
                            ->live()
                            ->columnSpan(2),
                        Radio::make('thunder_x')
                            ->label(__('app.stock_fees.thunder_membership'))
                            ->options([
                                StockFeesCalculatorService::THUNDER_X_NO => __('app.stock_fees.no'),
                                StockFeesCalculatorService::THUNDER_X_YES => __('app.stock_fees.yes'),
                            ])
                            ->default(StockFeesCalculatorService::THUNDER_X_NO)
                            ->inline()
                            ->live()
                            ->columnSpan(2),
                        Radio::make('settlement_type')
                            ->label(__('app.stock_fees.settlement_type'))
                            ->options([
                                StockFeesCalculatorService::SETTLEMENT_T0 => __('app.stock_fees.settlement_t0'),
                                StockFeesCalculatorService::SETTLEMENT_T1_T2 => __('app.stock_fees.settlement_t1_t2'),
                            ])
                            ->default(StockFeesCalculatorService::SETTLEMENT_T0)
                            ->inline()
                            ->live()
                            ->columnSpan(2),
                        TextInput::make('trade_value')
                            ->label(__('app.stock_fees.trade_value'))
                            ->numeric()
                            ->minValue(0)
                            ->required()
                            ->prefix('EGP')
                            ->step(0.01)
                            ->placeholder('0.00')
                            ->live()
                            ->visible(fn (Get $get): bool => $get('input_method') === StockFeesCalculatorService::INPUT_METHOD_TRADE_VALUE)
                            ->columnSpan(2),
                        TextInput::make('quantity')
                            ->label(__('app.stock_fees.quantity'))
                            ->numeric()
                            ->minValue(0)
                            ->step(0.0001)
                            ->placeholder('0')
                            ->live()
                            ->visible(fn (Get $get): bool => $get('input_method') === StockFeesCalculatorService::INPUT_METHOD_QUANTITY),
                        TextInput::make('share_price')
                            ->label(__('app.stock_fees.share_price'))
                            ->numeric()
                            ->minValue(0)
                            ->prefix('EGP')
                            ->step(0.0001)
                            ->placeholder('0.0000')
                            ->live()
                            ->visible(fn (Get $get): bool => $get('input_method') === StockFeesCalculatorService::INPUT_METHOD_QUANTITY),
                    ]),
            ]);
    }

    /**
     * @return array<string, array<int, string>>
     */
    protected function rules(): array
    {
        return [
            'data.input_method' => ['required', 'in:trade_value,quantity'],
            'data.thunder_x' => ['required', 'in:no,yes'],
            'data.settlement_type' => ['required', 'in:t0,t1_t2'],
            'data.trade_value' => ['nullable', 'numeric', 'min:0'],
            'data.quantity' => ['nullable', 'numeric', 'min:0'],
            'data.share_price' => ['nullable', 'numeric', 'min:0'],
        ];
    }

    public function getResults(): StockFeesCalculationResult
    {
        return StockFeesCalculatorService::make()->calculate($this->data ?? []);
    }
}
