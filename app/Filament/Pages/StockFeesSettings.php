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

    protected static ?string $navigationLabel = 'Stock Fees Settings';

    protected static string|\UnitEnum|null $navigationGroup = 'Financial Tools';

    protected static ?int $navigationSort = 2;

    protected string $view = 'filament.pages.stock-fees-settings';

    public ?array $data = [];

    public ?StockFeeSetting $setting = null;

    public function mount(): void
    {
        $this->setting = StockFeeSetting::current();

        $this->form->fill($this->setting->toArray());
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
                Section::make('Thunder Commission')
                    ->columns(2)
                    ->schema([
                        TextInput::make('thunder_percentage')
                            ->label('Thunder Percentage')
                            ->numeric()
                            ->step(0.0001)
                            ->suffix('%'),
                        TextInput::make('thunder_fixed_fee')
                            ->label('Thunder Fixed Fee')
                            ->numeric()
                            ->step(0.0001),
                    ]),
                Section::make('Exchange Fees')
                    ->description('Applied as a percentage of the trade value.')
                    ->columns(2)
                    ->schema([
                        TextInput::make('exchange_fee_percentage')
                            ->label('Exchange Fee')
                            ->numeric()
                            ->step(0.0001)
                            ->suffix('%'),
                        TextInput::make('egx_fee_percentage')
                            ->label('EGX Fee')
                            ->numeric()
                            ->step(0.0001)
                            ->suffix('%'),
                        TextInput::make('misr_clearing_fee_percentage')
                            ->label('Misr Clearing Fee')
                            ->numeric()
                            ->step(0.0001)
                            ->suffix('%'),
                        TextInput::make('fra_fee_percentage')
                            ->label('FRA Fee')
                            ->numeric()
                            ->step(0.0001)
                            ->suffix('%'),
                    ]),
            ]);
    }

    public function save(): void
    {
        $data = $this->form->getState();

        $this->setting->update($data);

        Notification::make()
            ->title('Settings saved successfully')
            ->success()
            ->send();
    }
}
