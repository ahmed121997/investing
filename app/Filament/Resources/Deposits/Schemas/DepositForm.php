<?php

namespace App\Filament\Resources\Deposits\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Hidden;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Auth;

class DepositForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Hidden::make('user_id')
                    ->default(Auth::id()),
                TextInput::make('amount')
                    ->label(__('app.amount'))
                    ->numeric()
                    ->required()
                    ->prefix('$')
                    ->step(0.01),
                DatePicker::make('deposit_date')
                    ->label(__('app.deposit_date'))
                    ->native(false)
                    ->required(),
                Textarea::make('description')
                    ->label(__('app.description'))
                    ->nullable()
                    ->columnSpan('full'),
            ]);
    }
}
