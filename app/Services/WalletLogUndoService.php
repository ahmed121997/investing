<?php

namespace App\Services;

use App\Models\Wallet;
use App\Models\WalletLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class WalletLogUndoService
{
    public function undo(WalletLog $walletLog): void
    {
        DB::transaction(function () use ($walletLog): void {
            if ((int) $walletLog->wallet()->value('user_id') !== (int) Auth::id()) {
                throw ValidationException::withMessages([
                    'wallet' => [__('app.authentication_required')],
                ]);
            }

            $wallet = Wallet::query()
                ->whereKey($walletLog->wallet_id)
                ->lockForUpdate()
                ->firstOrFail();
            $cashInCents = $this->toCents($wallet->cash) - $this->toCents($walletLog->cash_change);
            $saveCloudInCents = $this->toCents($wallet->save_cloud);

            if ($walletLog->save_cloud_before !== null && $walletLog->save_cloud_after !== null) {
                $saveCloudInCents += $this->toCents($walletLog->save_cloud_before)
                    - $this->toCents($walletLog->save_cloud_after);
            }

            if ($cashInCents < 0 || $saveCloudInCents < 0) {
                throw ValidationException::withMessages([
                    'wallet' => [__('app.wallet_log_undo_invalid_balance')],
                ]);
            }

            $wallet->update([
                'cash' => $this->fromCents($cashInCents),
                'save_cloud' => $this->fromCents($saveCloudInCents),
            ]);
            $walletLog->delete();
        });
    }

    private function toCents(mixed $amount): int
    {
        return (int) round(((float) $amount) * 100);
    }

    private function fromCents(int $amount): string
    {
        return number_format($amount / 100, 2, '.', '');
    }
}
