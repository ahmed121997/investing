<?php

namespace App\Filament\Resources\WalletLogs;

use App\Filament\Resources\WalletLogs\Pages\ListWalletLogs;
use App\Filament\Resources\WalletLogs\Tables\WalletLogsTable;
use App\Models\WalletLog;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class WalletLogResource extends Resource
{
    protected static ?string $model = WalletLog::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-document-text';

    public static function getNavigationSort(): ?int
    {
        return 6;
    }

    public static function getNavigationLabel(): string
    {
        return __('app.wallet_logs');
    }

    public static function getModelLabel(): string
    {
        return __('app.wallet_log');
    }

    public static function getPluralModelLabel(): string
    {
        return __('app.wallet_logs');
    }

    public static function table(Table $table): Table
    {
        return WalletLogsTable::configure($table);
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->whereHas('wallet', fn (Builder $query): Builder => $query->where('user_id', Auth::id()));
    }

    public static function getPages(): array
    {
        return [
            'index' => ListWalletLogs::route('/'),
        ];
    }
}
