<?php

namespace Tests\Feature;

use App\Models\Deposit;
use App\Models\User;
use App\Models\Wallet;
use App\Models\WalletLog;
use App\Models\Withdrawal;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;

class DepositWithdrawalWalletTest extends TestCase
{
    use RefreshDatabase;

    public function test_deposits_and_withdrawals_adjust_cash_and_create_logs_for_each_mutation(): void
    {
        $user = User::factory()->create();
        Wallet::create(['user_id' => $user->id, 'cash' => 100, 'save_cloud' => 0]);

        $deposit = Deposit::create([
            'user_id' => $user->id,
            'amount' => 50,
            'deposit_date' => '2026-09-06',
        ]);
        $deposit->update(['amount' => 75]);
        $deposit->delete();

        $withdrawal = Withdrawal::create([
            'user_id' => $user->id,
            'amount' => 25,
            'withdrawal_date' => '2026-09-06',
        ]);
        $withdrawal->update(['amount' => 40]);
        $withdrawal->delete();

        $this->assertDatabaseHas('wallets', ['user_id' => $user->id, 'cash' => 100]);
        $this->assertSame(6, WalletLog::query()->count());
        $this->assertSame(3, WalletLog::query()->where('transaction_type', 'deposit')->count());
        $this->assertSame(3, WalletLog::query()->where('transaction_type', 'withdrawal')->count());
        $this->assertDatabaseHas('wallet_logs', [
            'transaction_type' => 'deposit',
            'action' => 'updated',
            'cash_change' => 25,
            'cash_before' => 150,
            'cash_after' => 175,
        ]);
        $this->assertDatabaseHas('wallet_logs', [
            'transaction_type' => 'withdrawal',
            'action' => 'updated',
            'cash_change' => -15,
            'cash_before' => 75,
            'cash_after' => 60,
        ]);
    }

    public function test_withdrawal_cannot_reduce_cash_below_zero(): void
    {
        $user = User::factory()->create();
        Wallet::create(['user_id' => $user->id, 'cash' => 10, 'save_cloud' => 0]);

        $this->expectException(ValidationException::class);

        Withdrawal::create([
            'user_id' => $user->id,
            'amount' => 10.01,
            'withdrawal_date' => '2026-09-06',
        ]);
    }
}
