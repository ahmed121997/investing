<?php

namespace App\Filament\Widgets;

use App\Models\User;
use App\Models\Stock;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\Auth;

class DepositWithdrawalStats extends BaseWidget
{
    protected function getStats(): array
    {
        $user = User::find(Auth::id());

        $totalDeposits = $user->deposits()->sum('amount') ?? 0;
        $totalWithdrawals = $user->withdrawals()->sum('amount') ?? 0;
        $balance = $totalDeposits - $totalWithdrawals;
        $totalStocks = Stock::count();

        // Get profile image URL
        $profileImageUrl = null;
        if ($user->hasMedia('avatars')) {
            $profileImageUrl = $user->getFirstMediaUrl('avatars');
        }

        return [
            Stat::make('Total Deposits', '$' . number_format($totalDeposits, 2))
                ->description('Sum of all deposits')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('success'),
            Stat::make('Total Withdrawals', '$' . number_format($totalWithdrawals, 2))
                ->description('Sum of all withdrawals')
                ->descriptionIcon('heroicon-m-arrow-trending-down')
                ->color('danger'),
            Stat::make('Balance', '$' . number_format($balance, 2))
                ->description('Deposits minus withdrawals')
                ->descriptionIcon('heroicon-m-banknotes')
                ->color($balance >= 0 ? 'success' : 'danger'),
            Stat::make('Stocks', $totalStocks)
                ->description('Number of stocks in portfolio')
                ->descriptionIcon('heroicon-m-chart-bar-square')
                ->color('warning'),
        ];
    }
}
