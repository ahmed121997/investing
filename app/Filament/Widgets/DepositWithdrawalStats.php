<?php

namespace App\Filament\Widgets;

use App\Models\User;
use App\Models\Stock;
use App\Models\Trade;
use App\Models\Wallet;
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
        $walletTotal = $this->walletTotal();
        $profit = $walletTotal - $balance;
        $profitPercentage = $balance > 0 ? round(($profit / $balance) * 100, 1) : 0;

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
                ->description($profitPercentage . '% profit')
                ->descriptionIcon('heroicon-m-banknotes')
                ->color($balance >= 0 ? 'success' : 'danger'),
            Stat::make('Stocks', $totalStocks)
                ->description('Number of stocks in portfolio')
                ->descriptionIcon('heroicon-m-chart-bar-square')
                ->color('warning'),
        ];
    }

    private function walletTotal(): float
    {
        $openStocksTotal = (float) Trade::query()
            ->join('stocks', 'stocks.id', '=', 'trades.stock_id')
            ->where('trades.status', 'open')
            ->selectRaw('COALESCE(SUM(trades.amount * stocks.price), 0) as total')
            ->value('total');

        $wallet = Wallet::query()->firstOrCreate(
            ['user_id' => Auth::id()],
            ['cash' => 0, 'save_cloud' => 0],
        );

        return $openStocksTotal + (float) $wallet->cash + (float) $wallet->save_cloud;
    }
}
