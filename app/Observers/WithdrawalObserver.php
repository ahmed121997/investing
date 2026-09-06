<?php

namespace App\Observers;

use App\Models\Withdrawal;
use App\Services\WalletCashService;

class WithdrawalObserver
{
    public function __construct(private readonly WalletCashService $walletService) {}

    public function creating(Withdrawal $withdrawal): void
    {
        $this->walletService->validateImpact($withdrawal->user_id, $this->impactInCents($withdrawal));
    }

    public function created(Withdrawal $withdrawal): void
    {
        $impact = $this->impactInCents($withdrawal);
        $wallet = $this->walletService->applyImpact($withdrawal->user_id, $impact);
        $this->walletService->log($wallet, 'created', 'withdrawal', $withdrawal->amount, $impact);
    }

    public function updating(Withdrawal $withdrawal): void
    {
        $oldUserId = (int) $withdrawal->getOriginal('user_id');
        $newImpact = $this->impactInCents($withdrawal);
        $oldImpact = $this->impactInCentsFromAmount($withdrawal->getOriginal('amount'));

        if ($oldUserId === (int) $withdrawal->user_id) {
            $this->walletService->validateImpact($oldUserId, $newImpact - $oldImpact);

            return;
        }

        $this->walletService->validateImpact((int) $withdrawal->user_id, $newImpact);
    }

    public function updated(Withdrawal $withdrawal): void
    {
        $oldUserId = (int) $withdrawal->getOriginal('user_id');
        $newImpact = $this->impactInCents($withdrawal);
        $oldImpact = $this->impactInCentsFromAmount($withdrawal->getOriginal('amount'));

        if ($oldUserId !== (int) $withdrawal->user_id) {
            $oldWallet = $this->walletService->applyImpact($oldUserId, -$oldImpact);
            $this->walletService->log($oldWallet, 'updated', 'withdrawal', $withdrawal->getOriginal('amount'), -$oldImpact);
            $newWallet = $this->walletService->applyImpact((int) $withdrawal->user_id, $newImpact);
            $this->walletService->log($newWallet, 'updated', 'withdrawal', $withdrawal->amount, $newImpact);

            return;
        }

        $impact = $newImpact - $oldImpact;
        $wallet = $this->walletService->applyImpact((int) $withdrawal->user_id, $impact);
        $this->walletService->log($wallet, 'updated', 'withdrawal', $withdrawal->amount, $impact);
    }

    public function deleted(Withdrawal $withdrawal): void
    {
        $impact = -$this->impactInCents($withdrawal);
        $wallet = $this->walletService->applyImpact($withdrawal->user_id, $impact);
        $this->walletService->log($wallet, 'deleted', 'withdrawal', $withdrawal->amount, $impact);
    }

    private function impactInCents(Withdrawal $withdrawal): int
    {
        return -$this->impactInCentsFromAmount($withdrawal->amount);
    }

    private function impactInCentsFromAmount(string|int|float|null $amount): int
    {
        return (int) round(((float) $amount) * 100);
    }
}
