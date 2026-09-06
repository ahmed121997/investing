<?php

namespace App\Filament\Resources\Deposits;

use App\Filament\Resources\Deposits\Pages\ListDeposits;
use App\Filament\Resources\Deposits\Schemas\DepositForm;
use App\Filament\Resources\Deposits\Tables\DepositsTable;
use App\Models\Deposit;
use App\Models\User;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class DepositResource extends Resource
{
    protected static ?string $model = Deposit::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-arrow-up-circle';

    public static function getNavigationSort(): ?int
    {
        return 2;
    }

    public static function getNavigationLabel(): string
    {
        return __('app.deposits');
    }

    public static function getModelLabel(): string
    {
        return __('app.deposit');
    }

    public static function getPluralModelLabel(): string
    {
        return __('app.deposits');
    }

    public static function form(Schema $schema): Schema
    {
        return DepositForm::configure($schema);
    }

    public static function getEloquentQuery(): Builder
    {
        $isAdmin = User::query()->whereKey(Auth::id())->where('role', 'admin')->exists();

        return parent::getEloquentQuery()
            ->when(! $isAdmin, fn (Builder $query): Builder => $query->where('user_id', Auth::id()));
    }

    public static function table(Table $table): Table
    {
        return DepositsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListDeposits::route('/'),
        ];
    }
}
