<x-filament-panels::page>
    {{ $this->form }}

    @php($results = $this->getResults())

    <x-filament::section>
        <x-slot name="heading">
            Results
        </x-slot>

        <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
            @foreach ([
                'Trade Value' => ['trade_value', $results['trade_value']],
                'Thunder Commission' => ['thunder_commission', $results['thunder_commission']],
                'Exchange Fees' => ['exchange_fees', $results['exchange_fees']],
                'Total Fees' => ['total_fees', $results['total_fees']],
                'Net Cost' => ['net_cost', $results['net_cost']],
                'Break-even Share Price' => ['break_even_share_price', $results['break_even_share_price']],
            ] as $label => [$key, $value])
                <div class="rounded-xl bg-gray-50 p-4 dark:bg-white/5" x-data="{ copied: false }">
                    <div class="flex items-center justify-between gap-2">
                        <span class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ $label }}</span>
                        <button
                            type="button"
                            x-on:click="navigator.clipboard.writeText(@js(number_format((float) $value, 6, '.', ''))).then(() => { copied = true; setTimeout(() => copied = false, 1500); })"
                            class="shrink-0 text-gray-400 transition hover:text-primary-600 dark:hover:text-primary-400"
                            :title="copied ? 'Copied!' : 'Copy to clipboard'"
                        >
                            <x-heroicon-o-clipboard x-show="!copied" class="h-4 w-4" />
                            <x-heroicon-o-check-circle x-show="copied" class="h-4 w-4 text-success-600 dark:text-success-400" />
                        </button>
                    </div>
                    <div class="mt-2 text-2xl font-bold text-gray-950 dark:text-white">
                        @if ($value === null)
                            —
                        @else
                            {{ number_format((float) $value, 2) }}
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </x-filament::section>
</x-filament-panels::page>
