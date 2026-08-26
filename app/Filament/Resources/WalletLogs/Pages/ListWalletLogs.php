<?php

namespace App\Filament\Resources\WalletLogs\Pages;

use App\Filament\Resources\WalletLogs\WalletLogResource;
use App\Models\Wallet;
use App\Models\WalletLog;
use Filament\Actions\Action;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class ListWalletLogs extends ListRecords
{
    protected static string $resource = WalletLogResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('transfer')
                ->label(__('app.dashboard.transfer'))
                ->icon('heroicon-o-arrows-right-left')
                ->form([
                    Select::make('direction')
                        ->label(__('app.dashboard.transfer'))
                        ->options([
                            'cash_to_save_cloud' => __('app.cash_to_save_cloud'),
                            'save_cloud_to_cash' => __('app.save_cloud_to_cash'),
                        ])
                        ->default('cash_to_save_cloud')
                        ->required(),
                    TextInput::make('amount')
                        ->label(__('app.amount'))
                        ->numeric()
                        ->minValue(0.01)
                        ->step(0.01)
                        ->required(),
                ])
                ->action(function (array $data): void {
                    $amountInCents = (int) round(((float) $data['amount']) * 100);

                    DB::transaction(function () use ($data, $amountInCents): void {
                        $wallet = Wallet::query()->where('user_id', Auth::id())->lockForUpdate()->firstOrCreate(
                            ['user_id' => Auth::id()], ['cash' => 0, 'save_cloud' => 0],
                        );
                        $cashInCents = (int) round(((float) $wallet->cash) * 100);
                        $saveCloudInCents = (int) round(((float) $wallet->save_cloud) * 100);
                        $cashBefore = $cashInCents / 100;
                        $saveCloudBefore = $saveCloudInCents / 100;

                        if ($data['direction'] === 'cash_to_save_cloud') {
                            if ($cashInCents < $amountInCents) {
                                throw ValidationException::withMessages(['amount' => [__('app.dashboard.insufficient_transfer_balance')]]);
                            }
                            $cashInCents -= $amountInCents;
                            $saveCloudInCents += $amountInCents;
                        } else {
                            if ($saveCloudInCents < $amountInCents) {
                                throw ValidationException::withMessages(['amount' => [__('app.dashboard.insufficient_transfer_balance')]]);
                            }
                            $cashInCents += $amountInCents;
                            $saveCloudInCents -= $amountInCents;
                        }

                        $wallet->update([
                            'cash' => number_format($cashInCents / 100, 2, '.', ''),
                            'save_cloud' => number_format($saveCloudInCents / 100, 2, '.', ''),
                        ]);
                        WalletLog::create([
                            'wallet_id' => $wallet->id,
                            'action' => 'transferred',
                            'transaction_type' => $data['direction'],
                            'amount' => number_format($amountInCents / 100, 2, '.', ''),
                            'cash_change' => number_format(($cashInCents / 100) - $cashBefore, 2, '.', ''),
                            'cash_before' => number_format($cashBefore, 2, '.', ''),
                            'cash_after' => number_format($cashInCents / 100, 2, '.', ''),
                            'save_cloud_before' => number_format($saveCloudBefore, 2, '.', ''),
                            'save_cloud_after' => number_format($saveCloudInCents / 100, 2, '.', ''),
                        ]);
                    });

                    Notification::make()->title(__('app.dashboard.transfer_completed'))->success()->send();
                }),
        ];
    }
}
