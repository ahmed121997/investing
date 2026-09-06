<?php

namespace App\Filament\Resources\Users\Tables;

use App\Models\User;
use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Support\Enums\Alignment;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;

class UsersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label(__('app.name'))
                    ->searchable()
                    ->sortable(),
                TextColumn::make('email')
                    ->label(__('app.email'))
                    ->searchable()
                    ->sortable(),
                TextColumn::make('role')
                    ->label(__('app.role'))
                    ->formatStateUsing(fn (string $state): string => __('app.'.$state.'_role'))
                    ->badge()
                    ->alignment(Alignment::Center),
                ToggleColumn::make('is_active')
                    ->label(__('app.active'))
                    ->disabled(fn (User $record): bool => $record->isCurrentUser()),
                TextColumn::make('created_at')
                    ->label(__('app.created'))
                    ->dateTime('M d, Y')
                    ->sortable(),
            ])
            ->recordActions([
                Action::make('loginAs')
                    ->label(__('app.login_as'))
                    ->icon('heroicon-o-arrow-right-start-on-rectangle')
                    ->requiresConfirmation()
                    ->visible(fn (User $record): bool => $record->is_active && ! $record->isCurrentUser())
                    ->action(function (User $record) {
                        $adminId = Auth::id();
                        $guard = Auth::guard('web');

                        $guard->login($record);
                        session()->put([
                            'impersonating_admin_id' => $adminId,
                            'password_hash_web' => $record->getAuthPassword(),
                        ]);

                        return redirect('/admin');
                    }),
                EditAction::make()->iconButton(),
                DeleteAction::make()
                    ->iconButton()
                    ->visible(fn (User $record): bool => ! $record->isCurrentUser()),
            ])
            ->bulkActions([]);
    }
}
