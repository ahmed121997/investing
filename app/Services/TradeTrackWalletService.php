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
        $this->validateBalanceForImpact($this->ownerId($tradeTrack), $this->cashImpactInCents($tradeTrack) - $previousImpactInCents);
    }

    public function apply(TradeTrack $tradeTrack, int $previousImpactInCents = 0): Wallet
    {
        return $this->applyImpact($this->ownerId($tradeTrack), $this->cashImpactInCents($tradeTrack) - $previousImpactInCents);
    }

    public function applyImpact(int $userId, int $impactInCents): Wallet
    {
        $wallet = $this->walletForUser($userId);
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

    private function validateBalanceForImpact(int $userId, int $impactInCents): void
    {
        $wallet = $this->walletForUser($userId);

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
            'buy', 'sell', 'profit' => $amountInCents,
            default => throw ValidationException::withMessages([
                'type' => [__('app.invalid_trade_track_type')],
            ]),
        };
    }

    private function walletForUser(int $userId): Wallet
    {
        if ($userId < 1) {
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

    private function ownerId(TradeTrack $tradeTrack): int
    {
        $ownerId = $tradeTrack->trade?->user_id;

        if (! $ownerId) {
            throw ValidationException::withMessages([
                'trade_id' => [__('app.authentication_required')],
            ]);
        }

        if (Auth::id() !== null && (int) Auth::id() !== (int) $ownerId) {
            throw ValidationException::withMessages([
                'trade_id' => [__('app.authentication_required')],
            ]);
        }

        return (int) $ownerId;
    }

    private function cashInCents(Wallet $wallet): int
    {
        return (int) round(((float) $wallet->cash) * 100);
    }
}
