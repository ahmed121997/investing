<?php

namespace App\Observers;

use App\Models\Deposit;
use App\Services\WalletCashService;

class DepositObserver
{
    public function __construct(private readonly WalletCashService $walletService) {}

    public function creating(Deposit $deposit): void
    {
        $this->walletService->validateImpact($deposit->user_id, $this->impactInCents($deposit));
    }

    public function created(Deposit $deposit): void
    {
        $impact = $this->impactInCents($deposit);
        $wallet = $this->walletService->applyImpact($deposit->user_id, $impact);
        $this->walletService->log($wallet, 'created', 'deposit', $deposit->amount, $impact);
    }

    public function updating(Deposit $deposit): void
    {
        $this->validateUpdate($deposit);
    }

    public function updated(Deposit $deposit): void
    {
        $this->applyUpdate($deposit);
    }

    public function deleted(Deposit $deposit): void
    {
        $impact = -$this->impactInCents($deposit);
        $wallet = $this->walletService->applyImpact($deposit->user_id, $impact);
        $this->walletService->log($wallet, 'deleted', 'deposit', $deposit->amount, $impact);
    }

    private function validateUpdate(Deposit $deposit): void
    {
        $oldUserId = (int) $deposit->getOriginal('user_id');
        $newImpact = $this->impactInCents($deposit);
        $oldImpact = $this->impactInCentsFromAmount($deposit->getOriginal('amount'));

        if ($oldUserId === (int) $deposit->user_id) {
            $this->walletService->validateImpact($oldUserId, $newImpact - $oldImpact);

            return;
        }

        $this->walletService->validateImpact((int) $deposit->user_id, $newImpact);
    }

    private function applyUpdate(Deposit $deposit): void
    {
        $oldUserId = (int) $deposit->getOriginal('user_id');
        $newImpact = $this->impactInCents($deposit);
        $oldImpact = $this->impactInCentsFromAmount($deposit->getOriginal('amount'));

        if ($oldUserId !== (int) $deposit->user_id) {
            $oldWallet = $this->walletService->applyImpact($oldUserId, -$oldImpact);
            $this->walletService->log($oldWallet, 'updated', 'deposit', $deposit->getOriginal('amount'), -$oldImpact);
            $newWallet = $this->walletService->applyImpact((int) $deposit->user_id, $newImpact);
            $this->walletService->log($newWallet, 'updated', 'deposit', $deposit->amount, $newImpact);

            return;
        }

        $impact = $newImpact - $oldImpact;
        $wallet = $this->walletService->applyImpact((int) $deposit->user_id, $impact);
        $this->walletService->log($wallet, 'updated', 'deposit', $deposit->amount, $impact);
    }

    private function impactInCents(Deposit $deposit): int
    {
        return $this->impactInCentsFromAmount($deposit->amount);
    }

    private function impactInCentsFromAmount(string|int|float|null $amount): int
    {
        return (int) round(((float) $amount) * 100);
    }
}
