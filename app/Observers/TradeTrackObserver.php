<?php

namespace App\Observers;

use App\Models\TradeTrack;
use App\Models\Wallet;
use App\Models\WalletLog;
use App\Services\TradeTrackWalletService;
use Illuminate\Support\Facades\Log;

class TradeTrackObserver
{
    public function __construct(private readonly TradeTrackWalletService $walletService) {}

    public function creating(TradeTrack $tradeTrack): void
    {
        $this->walletService->validateBalanceFor($tradeTrack);
    }

    public function created(TradeTrack $tradeTrack): void
    {
        $wallet = $this->walletService->apply($tradeTrack);
        $cashChangeInCents = $this->walletService->cashImpactInCents($tradeTrack);

        $this->logWalletChange($tradeTrack, $wallet, 'created', $cashChangeInCents);
    }

    public function updating(TradeTrack $tradeTrack): void
    {
        $this->walletService->validateBalanceFor($tradeTrack, $this->previousImpactInCents($tradeTrack));
    }

    public function updated(TradeTrack $tradeTrack): void
    {
        $previousImpactInCents = $this->previousImpactInCents($tradeTrack);
        $wallet = $this->walletService->apply($tradeTrack, $previousImpactInCents);
        $cashChangeInCents = $this->walletService->cashImpactInCents($tradeTrack) - $previousImpactInCents;

        $this->logWalletChange($tradeTrack, $wallet, 'updated', $cashChangeInCents);
    }

    public function deleted(TradeTrack $tradeTrack): void
    {
        $previousImpactInCents = $this->walletService->cashImpactInCents($tradeTrack);
        $wallet = $this->walletService->applyImpact(-$previousImpactInCents);

        $this->logWalletChange($tradeTrack, $wallet, 'deleted', -$previousImpactInCents);
    }

    private function previousImpactInCents(TradeTrack $tradeTrack): int
    {
        return $this->walletService->cashImpactInCents(new TradeTrack([
            'amount' => $tradeTrack->getOriginal('amount'),
            'type' => $tradeTrack->getOriginal('type'),
        ]));
    }

    private function logWalletChange(TradeTrack $tradeTrack, Wallet $wallet, string $action, int $cashChangeInCents): void
    {
        $cashAfter = (float) $wallet->cash;
        $cashChange = $cashChangeInCents / 100;
        $context = [
            'trade_track_id' => $tradeTrack->id,
            'trade_id' => $tradeTrack->trade_id,
            'type' => $tradeTrack->type,
            'amount' => $tradeTrack->amount,
            'wallet_cash' => $cashAfter,
        ];

        WalletLog::create([
            'wallet_id' => $wallet->id,
            'trade_track_id' => $tradeTrack->id,
            'trade_id' => $tradeTrack->trade_id,
            'action' => $action,
            'transaction_type' => $tradeTrack->type,
            'amount' => $tradeTrack->amount,
            'cash_change' => $cashChange,
            'cash_before' => $cashAfter - $cashChange,
            'cash_after' => $cashAfter,
        ]);

        Log::info("Trade track {$action} and wallet cash adjusted.", $context);
    }
}
