<?php

namespace App\Filament\Pages;

use App\Models\StockFeeSetting;
use BackedEnum;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;

class StockFeesSettings extends Page
{
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedWrenchScrewdriver;

    protected static ?int $navigationSort = 2;

    protected string $view = 'filament.pages.stock-fees-settings';

    public static function getNavigationLabel(): string
    {
        return __('app.stock_fees.settings_page');
    }

    public static function getNavigationGroup(): string|\UnitEnum|null
    {
        return __('app.stock_fees.tools_group');
    }

    public function getTitle(): \Illuminate\Contracts\Support\Htmlable|string
    {
        return __('app.stock_fees.settings_page');
    }

    public ?array $data = [];

    public ?StockFeeSetting $setting = null;

    public function mount(): void
    {
        $this->setting = StockFeeSetting::current();

        $this->form->fill($this->setting->only(StockFeeSetting::defaultsFields()));
    }

    public function defaultForm(Schema $schema): Schema
    {
        return $schema->statePath('data');
    }

    public function form(Schema $schema): Schema
    {
        $defaults = StockFeeSetting::defaults();

        return $schema
            ->columns(1)
            ->schema([
                Section::make(__('app.stock_fees.section_thunder'))
                    ->columns(2)
                    ->schema([
                        TextInput::make('thunder_fixed_fee')
                            ->label(__('app.stock_fees.thunder_fixed_fee'))
                            ->numeric()
                            ->minValue(0)
                            ->required()
                            ->step(0.01)
                            ->suffix('EGP')
                            ->helperText(__('app.stock_fees.default_is', ['value' => $defaults['thunder_fixed_fee']])),
                        TextInput::make('thunder_percentage')
                            ->label(__('app.stock_fees.thunder_percentage'))
                            ->numeric()
                            ->minValue(0)
                            ->required()
                            ->step(0.0001)
                            ->suffix('%')
                            ->helperText(__('app.stock_fees.default_is', ['value' => $defaults['thunder_percentage']])),
                    ]),
                Section::make(__('app.stock_fees.section_exchange'))
                    ->description(__('app.stock_fees.section_exchange_description'))
                    ->columns(2)
                    ->schema([
                        TextInput::make('exchange_fee_percentage')
                            ->label(__('app.stock_fees.exchange_fee'))
                            ->numeric()
                            ->minValue(0)
                            ->required()
                            ->step(0.0001)
                            ->suffix('%')
                            ->helperText(__('app.stock_fees.default_is', ['value' => $defaults['exchange_fee_percentage']])),
                        TextInput::make('risk_fund_fee_percentage')
                            ->label(__('app.stock_fees.risk_fund_fee'))
                            ->numeric()
                            ->minValue(0)
                            ->required()
                            ->step(0.0001)
                            ->suffix('%')
                            ->helperText(__('app.stock_fees.default_is', ['value' => $defaults['risk_fund_fee_percentage']])),
                        TextInput::make('misr_clearing_fee_percentage')
                            ->label(__('app.stock_fees.misr_clearing_fee'))
                            ->numeric()
                            ->minValue(0)
                            ->required()
                            ->step(0.0001)
                            ->suffix('%')
                            ->helperText(__('app.stock_fees.default_is', ['value' => $defaults['misr_clearing_fee_percentage']])),
                        TextInput::make('fra_fee_percentage')
                            ->label(__('app.stock_fees.fra_fee'))
                            ->numeric()
                            ->minValue(0)
                            ->required()
                            ->step(0.0001)
                            ->suffix('%')
                            ->helperText(__('app.stock_fees.default_is', ['value' => $defaults['fra_fee_percentage']])),
                        TextInput::make('fra_fee_minimum')
                            ->label(__('app.stock_fees.fra_fee_minimum'))
                            ->numeric()
                            ->minValue(0)
                            ->required()
                            ->step(0.01)
                            ->suffix('EGP')
                            ->helperText(__('app.stock_fees.default_is', ['value' => $defaults['fra_fee_minimum']])),
                    ]),
                Section::make(__('app.stock_fees.section_tax'))
                    ->description(__('app.stock_fees.section_tax_description'))
                    ->columns(2)
                    ->schema([
                        TextInput::make('tax_t0_percentage')
                            ->label(__('app.stock_fees.tax_t0'))
                            ->numeric()
                            ->minValue(0)
                            ->required()
                            ->step(0.0001)
                            ->suffix('%')
                            ->helperText(__('app.stock_fees.default_is', ['value' => $defaults['tax_t0_percentage']])),
                        TextInput::make('tax_t1_t2_percentage')
                            ->label(__('app.stock_fees.tax_t1_t2'))
                            ->numeric()
                            ->minValue(0)
                            ->required()
                            ->step(0.0001)
                            ->suffix('%')
                            ->helperText(__('app.stock_fees.default_is', ['value' => $defaults['tax_t1_t2_percentage']])),
                    ]),
            ]);
    }

    /**
     * @return array<string, array<int, string>>
     */
    protected function rules(): array
    {
        return [
            'data.thunder_fixed_fee' => ['required', 'numeric', 'min:0'],
            'data.thunder_percentage' => ['required', 'numeric', 'min:0'],
            'data.exchange_fee_percentage' => ['required', 'numeric', 'min:0'],
            'data.risk_fund_fee_percentage' => ['required', 'numeric', 'min:0'],
            'data.misr_clearing_fee_percentage' => ['required', 'numeric', 'min:0'],
            'data.fra_fee_percentage' => ['required', 'numeric', 'min:0'],
            'data.fra_fee_minimum' => ['required', 'numeric', 'min:0'],
            'data.tax_t0_percentage' => ['required', 'numeric', 'min:0'],
            'data.tax_t1_t2_percentage' => ['required', 'numeric', 'min:0'],
        ];
    }

    public function save(): void
    {
        $data = $this->form->getState();

        $this->setting->update($data);

        Notification::make()
            ->title(__('app.stock_fees.settings_saved'))
            ->success()
            ->send();
    }
}
