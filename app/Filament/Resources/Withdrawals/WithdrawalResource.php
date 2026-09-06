<?php

namespace App\Filament\Resources\Withdrawals;

use App\Filament\Concerns\HidesFromAdminNavigation;
use App\Filament\Resources\Withdrawals\Pages\ListWithdrawals;
use App\Filament\Resources\Withdrawals\Schemas\WithdrawalForm;
use App\Filament\Resources\Withdrawals\Tables\WithdrawalsTable;
use App\Models\User;
use App\Models\Withdrawal;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class WithdrawalResource extends Resource
{
    use HidesFromAdminNavigation;
    protected static ?string $model = Withdrawal::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-arrow-down-circle';

    public static function getNavigationSort(): ?int
    {
        return 3;
    }

    public static function getNavigationLabel(): string
    {
        return __('app.withdrawals');
    }

    public static function getModelLabel(): string
    {
        return __('app.withdrawal');
    }

    public static function getPluralModelLabel(): string
    {
        return __('app.withdrawals');
    }

    public static function form(Schema $schema): Schema
    {
        return WithdrawalForm::configure($schema);
    }

    public static function getEloquentQuery(): Builder
    {
        $isAdmin = User::query()->whereKey(Auth::id())->where('role', 'admin')->exists();

        return parent::getEloquentQuery()
            ->when(! $isAdmin, fn (Builder $query): Builder => $query->where('user_id', Auth::id()));
    }

    public static function table(Table $table): Table
    {
        return WithdrawalsTable::configure($table);
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
            'index' => ListWithdrawals::route('/'),
        ];
    }
}
