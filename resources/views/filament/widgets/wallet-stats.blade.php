<x-filament-widgets::widget>
    <div
        class="wallet-stats-grid grid w-full grid-cols-1 items-stretch gap-4 md:grid-cols-2 xl:grid-cols-3"
    >
        <form wire:submit="save" class="flex h-full min-w-0 w-full">
            <x-filament::section class="h-full w-full" style="width: 100%; height: 100%;">
                <div
                    class="flex h-full min-h-24 min-w-0 flex-col items-center justify-center text-center"
                    style="display: flex; min-height: 6rem; height: 100%; flex-direction: column; align-items: center; justify-content: center; text-align: center;"
                >
                    <div class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Open Stocks</div>
                    <div class="mt-2 max-w-full text-2xl font-bold text-gray-950 dark:text-white sm:text-3xl" style="margin-top: 0.5rem; font-weight: 700;">
                        {{ $this->formatMoney($this->openStocksTotal()) }}
                    </div>
                </div>
            </x-filament::section>
        </form>

        <form wire:submit="save" class="flex h-full min-w-0 w-full">
            <x-filament::section class="h-full w-full" style="width: 100%; height: 100%;">
                 <label for="wallet-cash" class="mt-5 block text-sm font-medium text-gray-500 dark:text-gray-400">
                    Total Cash
                </label>
                <div class="wallet-stats-field mt-2 flex flex-col gap-2 sm:flex-row sm:items-center" style="margin-top: 0.5rem; margin-bottom: 0.5rem;">
                    <x-filament::input.wrapper style="flex: 1 1 auto; min-width: 0;">
                        <x-filament::input
                            id="wallet-cash"
                            type="number"
                            step="0.01"
                            min="0"
                            wire:model="cash"
                        />
                    </x-filament::input.wrapper>

                    <x-filament::button type="submit" size="sm" class="wallet-stats-submit w-full shrink-0 sm:w-auto" style="flex: 0 0 auto;">
                        <x-filament::icon icon="heroicon-o-check" class="h-4 w-4" />
                    </x-filament::button>
                </div>
                <label for="wallet-save-cloud" class="text-sm font-medium text-gray-500 dark:text-gray-400">
                    Total Save Cloud
                </label>

                <div class="wallet-stats-field flex flex-col gap-2 sm:flex-row sm:items-center" style="margin-top: 0.5rem;">
                    <x-filament::input.wrapper style="flex: 1 1 auto; min-width: 0;">
                        <x-filament::input
                            id="wallet-save-cloud"
                            type="number"
                            step="0.01"
                            min="0"
                            wire:model="saveCloud"
                        />
                    </x-filament::input.wrapper>

                    <x-filament::button type="submit" size="sm" class="wallet-stats-submit w-full shrink-0 sm:w-auto" style="flex: 0 0 auto;">
                        <x-filament::icon icon="heroicon-o-check" class="h-4 w-4" />
                    </x-filament::button>
                </div>
            </x-filament::section>
        </form>

        <x-filament::section class="min-w-0 h-full w-full" style="min-width: 0; width: 100%; height: 100%;">
            <div
                class="flex h-full min-h-24 min-w-0 flex-col items-center justify-center text-center"
                style="display: flex; min-height: 6rem; height: 100%; flex-direction: column; align-items: center; justify-content: center; text-align: center;"
            >
                <div class="text-sm font-medium text-primary-700 dark:text-primary-300">Wallet Total</div>
                <div class="mt-2 max-w-full text-2xl font-bold text-primary-950 dark:text-primary-100 sm:text-3xl" style="margin-top: 0.5rem; font-weight: 700;">
                    {{ $this->formatMoney($this->walletTotal()) }}
                </div>
            </div>
        </x-filament::section>
    </div>
</x-filament-widgets::widget>
