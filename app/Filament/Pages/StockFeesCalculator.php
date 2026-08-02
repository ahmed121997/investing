<?php

namespace App\Filament\Pages;

use App\Services\StockFeesCalculatorService;
use BackedEnum;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Pages\Page;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;

class StockFeesCalculator extends Page
{
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCalculator;

    protected static ?string $navigationLabel = 'Stock Fees Calculator';

    protected static string|\UnitEnum|null $navigationGroup = 'Financial Tools';

    protected static ?int $navigationSort = 1;

    protected string $view = 'filament.pages.stock-fees-calculator';

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill([
            'input_method' => 'trade_value',
            'thunder_x' => 'no',
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
                Section::make('Trade Details')
                    ->columns(2)
                    ->schema([
                        Select::make('input_method')
                            ->label('Input Method')
                            ->options([
                                'trade_value' => 'Trade Value Directly',
                                'quantity' => 'Shares Quantity × Share Price',
                            ])
                            ->default('trade_value')
                            ->live(),
                        Select::make('thunder_x')
                            ->label('Thunder X Membership')
                            ->options([
                                'no' => 'No',
                                'yes' => 'Yes',
                            ])
                            ->default('no')
                            ->live(),
                        TextInput::make('trade_value')
                            ->label('Trade Value')
                            ->numeric()
                            ->prefix('EGP')
                            ->step(0.01)
                            ->live()
                            ->visible(fn (Get $get): bool => $get('input_method') === 'trade_value')
                            ->columnSpan(2),
                        TextInput::make('quantity')
                            ->label('Shares Quantity')
                            ->numeric()
                            ->step(0.0001)
                            ->live()
                            ->visible(fn (Get $get): bool => $get('input_method') === 'quantity'),
                        TextInput::make('share_price')
                            ->label('Share Price')
                            ->numeric()
                            ->prefix('EGP')
                            ->step(0.0001)
                            ->live()
                            ->visible(fn (Get $get): bool => $get('input_method') === 'quantity'),
                    ]),
            ]);
    }

    /**
     * @return array<string, mixed>
     */
    public function getResults(): array
    {
        return app(StockFeesCalculatorService::class)->calculate($this->data);
    }
}
