<?php

namespace Tests\Unit;

use App\Models\User;
use App\Models\Wallet;
use App\Models\WalletLog;
use App\Services\WalletLogUndoService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class WalletLogUndoServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_reverses_cash_and_save_cloud_and_deletes_a_transfer_log(): void
    {
        $wallet = Wallet::create([
            'user_id' => User::factory()->create()->id,
            'cash' => 75,
            'save_cloud' => 75,
        ]);
        $walletLog = WalletLog::create([
            'wallet_id' => $wallet->id,
            'action' => 'transferred',
            'transaction_type' => 'cash_to_save_cloud',
            'amount' => 25,
            'cash_change' => -25,
            'cash_before' => 100,
            'cash_after' => 75,
            'save_cloud_before' => 50,
            'save_cloud_after' => 75,
        ]);

        app(WalletLogUndoService::class)->undo($walletLog);

        $this->assertDatabaseHas('wallets', [
            'id' => $wallet->id,
            'cash' => 100,
            'save_cloud' => 50,
        ]);
        $this->assertDatabaseMissing('wallet_logs', ['id' => $walletLog->id]);
    }

    public function test_it_reverses_cash_only_logs_without_changing_save_cloud(): void
    {
        $wallet = Wallet::create([
            'user_id' => User::factory()->create()->id,
            'cash' => 125,
            'save_cloud' => 40,
        ]);
        $walletLog = WalletLog::create([
            'wallet_id' => $wallet->id,
            'action' => 'created',
            'transaction_type' => 'sell',
            'amount' => 25,
            'cash_change' => 25,
            'cash_before' => 100,
            'cash_after' => 125,
        ]);

        app(WalletLogUndoService::class)->undo($walletLog);

        $this->assertDatabaseHas('wallets', [
            'id' => $wallet->id,
            'cash' => 100,
            'save_cloud' => 40,
        ]);
        $this->assertDatabaseMissing('wallet_logs', ['id' => $walletLog->id]);
    }
}
