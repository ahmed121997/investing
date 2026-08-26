<?php

namespace App\Filament\Widgets;

use App\Models\Trade;
use App\Models\Wallet;
use Filament\Notifications\Notification;
use Filament\Widgets\Widget;
use Illuminate\Support\Facades\Auth;

class WalletStats extends Widget
{
    protected string $view = 'filament.widgets.wallet-stats';

    protected ?string $heading = null;

    public function getHeading(): string
    {
        return __('app.dashboard.wallet');
    }

    protected int|string|array $columnSpan = 'full';

    public ?float $cash = 0;

    public ?float $saveCloud = 0;

    public function mount(): void
    {
        $wallet = $this->wallet();

        $this->cash = (float) $wallet->cash;
        $this->saveCloud = (float) $wallet->save_cloud;
    }

    public function save(): void
    {
        $data = $this->validate([
            'cash' => ['required', 'numeric', 'min:0'],
            'saveCloud' => ['required', 'numeric', 'min:0'],
        ]);

        $this->wallet()->update([
            'cash' => $data['cash'],
            'save_cloud' => $data['saveCloud'],
        ]);

        Notification::make()
            ->title(__('app.dashboard.wallet_updated'))
            ->success()
            ->send();
    }

    public function openStocksTotal(): float
    {
        return (float) Trade::query()
            ->join('stocks', 'stocks.id', '=', 'trades.stock_id')
            ->where('trades.status', 'open')
            ->selectRaw('COALESCE(SUM(trades.amount * stocks.price), 0) as total')
            ->value('total');
    }

    public function walletTotal(): float
    {
        return $this->openStocksTotal() + (float) $this->cash + (float) $this->saveCloud;
    }

    public function formatMoney(float $amount): string
    {
        return number_format($amount, 2);
    }

    private function wallet(): Wallet
    {
        return Wallet::query()->firstOrCreate(
            ['user_id' => Auth::id()],
            ['cash' => 0, 'save_cloud' => 0],
        );
    }
}
