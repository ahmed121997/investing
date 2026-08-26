<?php

namespace App\Services;

use App\Models\TradeTrack;
use App\Models\Wallet;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class TradeTrackWalletService
{
    public function validateBalanceFor(TradeTrack $tradeTrack, int $previousImpactInCents = 0): void
    {
        $this->validateBalanceForImpact($this->cashImpactInCents($tradeTrack) - $previousImpactInCents);
    }

    public function apply(TradeTrack $tradeTrack, int $previousImpactInCents = 0): Wallet
    {
        return $this->applyImpact($this->cashImpactInCents($tradeTrack) - $previousImpactInCents);
    }

    public function applyImpact(int $impactInCents): Wallet
    {
        $wallet = $this->walletForCurrentUser();
        $newBalanceInCents = $this->cashInCents($wallet) + $impactInCents;

        if ($newBalanceInCents < 0) {
            throw ValidationException::withMessages([
                'amount' => [__('app.insufficient_cash_balance')],
            ]);
        }

        $wallet->update([
            'cash' => number_format($newBalanceInCents / 100, 2, '.', ''),
        ]);

        return $wallet;
    }

    private function validateBalanceForImpact(int $impactInCents): void
    {
        $wallet = $this->walletForCurrentUser();

        if ($this->cashInCents($wallet) + $impactInCents < 0) {
            throw ValidationException::withMessages([
                'amount' => [__('app.insufficient_cash_balance')],
            ]);
        }
    }

    public function cashImpactInCents(TradeTrack $tradeTrack): int
    {
        $amountInCents = (int) round(((float) $tradeTrack->amount) * 100);

        return match ($tradeTrack->type) {
            'buy' => -$amountInCents,
            'sell', 'profit' => $amountInCents,
            default => throw ValidationException::withMessages([
                'type' => [__('app.invalid_trade_track_type')],
            ]),
        };
    }

    private function walletForCurrentUser(): Wallet
    {
        $userId = Auth::id();

        if (! $userId) {
            throw ValidationException::withMessages([
                'amount' => [__('app.authentication_required')],
            ]);
        }

        Wallet::query()->firstOrCreate(
            ['user_id' => $userId],
            ['cash' => 0, 'save_cloud' => 0],
        );

        return Wallet::query()
            ->where('user_id', $userId)
            ->lockForUpdate()
            ->firstOrFail();
    }

    private function cashInCents(Wallet $wallet): int
    {
        return (int) round(((float) $wallet->cash) * 100);
    }
}
