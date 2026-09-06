<?php

namespace App\Services;

use App\Models\Wallet;
use App\Models\WalletLog;
use Illuminate\Validation\ValidationException;

class WalletCashService
{
    public function validateImpact(int $userId, int $cashImpactInCents): void
    {
        $wallet = $this->walletForUser($userId);

        if ($this->cashInCents($wallet) + $cashImpactInCents < 0) {
            throw ValidationException::withMessages([
                'amount' => [__('app.insufficient_cash_balance')],
            ]);
        }
    }

    public function applyImpact(int $userId, int $cashImpactInCents): Wallet
    {
        $wallet = $this->walletForUser($userId);
        $cashBeforeInCents = $this->cashInCents($wallet);
        $cashAfterInCents = $cashBeforeInCents + $cashImpactInCents;

        if ($cashAfterInCents < 0) {
            throw ValidationException::withMessages([
                'amount' => [__('app.insufficient_cash_balance')],
            ]);
        }

        $wallet->update([
            'cash' => number_format($cashAfterInCents / 100, 2, '.', ''),
        ]);

        return $wallet;
    }

    public function log(
        Wallet $wallet,
        string $action,
        string $transactionType,
        string|int|float $amount,
        int $cashImpactInCents,
        ?int $previousCashInCents = null,
    ): void {
        $cashAfter = (float) $wallet->cash;
        $cashChange = $cashImpactInCents / 100;
        $cashBefore = $previousCashInCents === null
            ? $cashAfter - $cashChange
            : $previousCashInCents / 100;

        WalletLog::create([
            'wallet_id' => $wallet->id,
            'action' => $action,
            'transaction_type' => $transactionType,
            'amount' => $amount,
            'cash_change' => $cashChange,
            'cash_before' => $cashBefore,
            'cash_after' => $cashAfter,
        ]);
    }

    private function walletForUser(int $userId): Wallet
    {
        $wallet = Wallet::query()->firstOrCreate(
            ['user_id' => $userId],
            ['cash' => 0, 'save_cloud' => 0],
        );

        return Wallet::query()
            ->whereKey($wallet->id)
            ->lockForUpdate()
            ->firstOrFail();
    }

    private function cashInCents(Wallet $wallet): int
    {
        return (int) round(((float) $wallet->cash) * 100);
    }
}
