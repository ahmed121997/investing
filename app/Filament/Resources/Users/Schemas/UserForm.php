<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label(__('app.name'))
                    ->required()
                    ->maxLength(255),
                TextInput::make('email')
                    ->label(__('app.email'))
                    ->email()
                    ->required()
                    ->unique(ignoreRecord: true),
                TextInput::make('password')
                    ->label(__('app.password'))
                    ->password()
                    ->required(fn (string $operation): bool => $operation === 'create')
                    ->dehydrated(fn (?string $state): bool => filled($state)),
                Select::make('role')
                    ->label(__('app.role'))
                    ->options([
                        'user' => __('app.user_role'),
                        'admin' => __('app.admin_role'),
                    ])
                    ->required(),
                Toggle::make('is_active')
                    ->label(__('app.active'))
                    ->default(true)
                    ->required(),
            ]);
    }
}
