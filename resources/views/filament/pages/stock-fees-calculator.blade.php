<x-filament-panels::page>
    <script>
        window.copyToClipboard = function (text) {
            if (navigator.clipboard && window.isSecureContext) {
                return navigator.clipboard.writeText(text);
            }

            return new Promise((resolve) => {
                const textarea = document.createElement('textarea');
                textarea.value = text;
                textarea.setAttribute('readonly', '');
                textarea.style.position = 'fixed';
                textarea.style.opacity = '0';
                document.body.appendChild(textarea);
                textarea.select();
                document.execCommand('copy');
                document.body.removeChild(textarea);
                resolve();
            });
        };
    </script>

    {{ $this->form }}

    @php($results = $this->getResults())
    @php($fmt = fn (?float $value, int $decimals = 2): ?string => $value === null ? null : number_format((float) $value, $decimals))
    @php($pct = fn (float $value): string => rtrim(rtrim(number_format((float) $value, 4), '0'), '.'))
    @php($copy = fn (?float $value, int $decimals = 2): string => $value === null ? '' : number_format((float) $value, $decimals, '.', ''))

    <x-filament::section>
        <x-slot name="heading">
            {{ __('app.stock_fees.results') }}
        </x-slot>
        <x-slot name="description">
            {{ __('app.stock_fees.results_description') }}
        </x-slot>

        <div class="space-y-6">
            {{-- Summary cards --}}
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">
                @php($summary = [
                    [
                        'label' => __('app.stock_fees.trade_value'),
                        'value' => $results->tradeValue,
                        'decimals' => 2,
                        'icon' => 'heroicon-o-banknotes',
                        'subtitle' => $results->inputMethod === 'quantity'
                            ? __('app.stock_fees.calculated_from_quantity')
                            : __('app.stock_fees.entered_directly'),
                        'highlight' => false,
                    ],
                    [
                        'label' => __('app.stock_fees.total_fees'),
                        'value' => $results->totalFees,
                        'decimals' => 2,
                        'icon' => 'heroicon-o-calculator',
                        'subtitle' => __('app.stock_fees.total_fees_hint'),
                        'highlight' => false,
                    ],
                    [
                        'label' => __('app.stock_fees.net_cost'),
                        'value' => $results->netCost,
                        'decimals' => 2,
                        'icon' => 'heroicon-o-wallet',
                        'subtitle' => __('app.stock_fees.net_cost_hint'),
                        'highlight' => true,
                    ],
                ])

                @foreach ($summary as $card)
                    <div
                        @class([
                            'relative overflow-hidden rounded-2xl p-5',
                            'bg-gradient-to-br from-amber-500 to-amber-600 text-white shadow-lg shadow-amber-500/20' => $card['highlight'],
                            'border border-gray-200 bg-white dark:border-white/10 dark:bg-gray-900/40' => ! $card['highlight'],
                        ])
                        x-data="{ copied: false }"
                    >
                        <div class="flex items-start justify-between gap-3">
                            <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl">
                                <x-dynamic-component
                                    :component="$card['icon']"
                                    @class(['h-5 w-5', 'text-white/90' => $card['highlight'], 'text-gray-500 dark:text-gray-400' => ! $card['highlight']])
                                />
                            </div>

                            @if ($copy($card['value'], $card['decimals']) !== '')
                                <button
                                    type="button"
                                    x-on:click="window.copyToClipboard(@js($copy($card['value'], $card['decimals']))).then(() => { copied = true; setTimeout(() => copied = false, 1500); })"
                                    @class([
                                        'shrink-0 rounded-lg p-1.5 transition',
                                        'bg-white/10 text-white/80 hover:bg-white/20 hover:text-white' => $card['highlight'],
                                        'text-gray-400 hover:bg-gray-100 hover:text-primary-600 dark:text-gray-500 dark:hover:bg-white/10 dark:hover:text-primary-400' => ! $card['highlight'],
                                    ])
                                    :title="copied ? @js(__('app.stock_fees.copied')) : @js(__('app.stock_fees.copy'))"
                                >
                                    <x-heroicon-o-clipboard x-show="!copied" class="h-4 w-4" />
                                    <x-heroicon-o-check-circle x-show="copied" class="h-4 w-4 text-success-400" />
                                </button>
                            @endif
                        </div>

                        <div class="mt-4">
                            <div @class(['text-sm font-medium', 'text-white/80' => $card['highlight'], 'text-gray-500 dark:text-gray-400' => ! $card['highlight']])>
                                {{ $card['label'] }}
                            </div>
                            <div class="mt-1 flex items-baseline gap-2">
                                <span class="text-3xl font-bold tabular-nums tracking-tight">
                                    {{ $fmt($card['value'], $card['decimals']) }}
                                </span>
                                <span @class(['text-sm font-medium', 'text-white/70' => $card['highlight'], 'text-gray-400 dark:text-gray-500' => ! $card['highlight']])>
                                    EGP
                                </span>
                            </div>
                            <div @class(['mt-1 text-xs', 'text-white/60' => $card['highlight'], 'text-gray-400 dark:text-gray-500' => ! $card['highlight']])>
                                {{ $card['subtitle'] }}
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Fee & tax breakdown (receipt style) --}}
            <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white dark:border-white/10 dark:bg-gray-900/40">
                <div class="flex items-center justify-between gap-3 border-b border-gray-100 px-5 py-4 dark:border-white/5">
                    <div class="flex items-center gap-2">
                        <x-heroicon-o-receipt-percent class="h-5 w-5 text-primary-600 dark:text-primary-400" />
                        <h3 class="text-sm font-semibold text-gray-950 dark:text-white">
                            {{ __('app.stock_fees.fee_breakdown') }}
                        </h3>
                    </div>
                    <span class="rounded-full bg-gray-100 px-2.5 py-0.5 text-xs font-medium text-gray-500 dark:bg-white/10 dark:text-gray-400">
                        EGP
                    </span>
                </div>

                <div class="divide-y divide-gray-100 dark:divide-white/5">
                    @php($breakdown = [
                        [
                            'label' => __('app.stock_fees.thunder_commission'),
                            'value' => $results->thunderCommission,
                            'icon' => 'heroicon-o-bolt',
                            'subtitle' => $results->thunderCommission > 0
                                ? __('app.stock_fees.thunder_rate_hint', ['fixed' => $fmt($results->thunderFixedFee) ?? '0.00', 'pct' => $pct($results->thunderPercentage)])
                                : __('app.stock_fees.thunder_x_waived'),
                        ],
                        [
                            'label' => __('app.stock_fees.exchange_fee_amount'),
                            'value' => $results->exchangeFeeAmount,
                            'icon' => 'heroicon-o-building-library',
                            'subtitle' => $pct($results->exchangeFeePercentage).'%',
                        ],
                        [
                            'label' => __('app.stock_fees.risk_fund_fee_amount'),
                            'value' => $results->riskFundFeeAmount,
                            'icon' => 'heroicon-o-banknotes',
                            'subtitle' => $pct($results->riskFundFeePercentage).'%',
                        ],
                        [
                            'label' => __('app.stock_fees.misr_clearing_fee_amount'),
                            'value' => $results->misrClearingFeeAmount,
                            'icon' => 'heroicon-o-shield-check',
                            'subtitle' => $pct($results->misrClearingFeePercentage).'%',
                        ],
                        [
                            'label' => __('app.stock_fees.fra_fee_amount'),
                            'value' => $results->fraFeeAmount,
                            'icon' => 'heroicon-o-scale',
                            'subtitle' => __('app.stock_fees.fra_fee_hint', [
                                'pct' => $pct($results->fraFeePercentage),
                                'min' => $fmt($results->fraFeeMinimum) ?? '0.00',
                            ]),
                        ],
                        [
                            'label' => __('app.stock_fees.total_exchange_fees'),
                            'value' => $results->totalExchangeFees,
                            'icon' => 'heroicon-o-chart-bar',
                            'subtitle' => __('app.stock_fees.sum_of_exchange_fees'),
                            'strong' => true,
                        ],
                        [
                            'label' => __('app.stock_fees.tax_amount'),
                            'value' => $results->taxAmount,
                            'icon' => 'heroicon-o-percent-badge',
                            'subtitle' => $pct($results->taxRate).'% ('.($results->settlementType === 't1_t2' ? 'T1/T2' : 'T0').')',
                        ],
                    ])

                    @foreach ($breakdown as $row)
                        <div
                            class="flex items-center justify-between gap-4 px-5 py-4"
                            x-data="{ copied: false }"
                        >
                            <div class="flex min-w-0 items-center gap-3">
                                <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-gray-100 dark:bg-white/5">
                                    <x-dynamic-component
                                        :component="$row['icon']"
                                        class="h-5 w-5 text-gray-500 dark:text-gray-400"
                                    />
                                </div>
                                <div class="min-w-0">
                                    <div @class([
                                        'text-sm font-medium text-gray-950 dark:text-white',
                                        'font-semibold' => isset($row['strong']) && $row['strong'],
                                    ])>
                                        {{ $row['label'] }}
                                    </div>
                                    <div class="truncate text-xs text-gray-400 dark:text-gray-500">
                                        {{ $row['subtitle'] }}
                                    </div>
                                </div>
                            </div>

                            <div class="flex shrink-0 items-center gap-3">
                                <div class="text-right">
                                    <div @class([
                                        'text-base font-semibold tabular-nums text-gray-950 dark:text-white',
                                        'font-bold text-primary-600 dark:text-primary-400' => isset($row['strong']) && $row['strong'],
                                    ])>
                                        {{ $fmt($row['value']) }}
                                    </div>
                                </div>

                                <button
                                    type="button"
                                    x-on:click="window.copyToClipboard(@js($copy($row['value']))).then(() => { copied = true; setTimeout(() => copied = false, 1500); })"
                                    class="shrink-0 rounded-lg p-1.5 text-gray-400 transition hover:bg-gray-100 hover:text-primary-600 dark:text-gray-500 dark:hover:bg-white/10 dark:hover:text-primary-400"
                                    :title="copied ? @js(__('app.stock_fees.copied')) : @js(__('app.stock_fees.copy'))"
                                >
                                    <x-heroicon-o-clipboard x-show="!copied" class="h-4 w-4" />
                                    <x-heroicon-o-check-circle x-show="copied" class="h-4 w-4 text-success-500" />
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Break-even share price --}}
            <div
                class="rounded-2xl border border-dashed border-primary-300 bg-primary-50 p-5 dark:border-primary-500/30 dark:bg-primary-500/10"
                x-data="{ copied: false }"
            >
                <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                    <div class="flex items-center gap-4">
                        <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl bg-primary-500 text-white shadow-lg shadow-primary-500/20">
                            <x-heroicon-o-chart-bar class="h-6 w-6" />
                        </div>
                        <div>
                            <div class="text-sm font-medium text-gray-500 dark:text-gray-400">
                                {{ __('app.stock_fees.break_even_share_price') }}
                            </div>
                            @if ($results->breakEvenSharePrice === null)
                                <div class="mt-1 text-sm text-gray-400 dark:text-gray-500">
                                    {{ __('app.stock_fees.no_quantity') }}
                                </div>
                            @else
                                <div class="mt-1 flex items-baseline gap-2">
                                    <span class="text-3xl font-bold tabular-nums tracking-tight text-gray-950 dark:text-white">
                                        {{ $fmt($results->breakEvenSharePrice, 4) }}
                                    </span>
                                    <span class="text-sm font-medium text-gray-400 dark:text-gray-500">EGP</span>
                                </div>
                                <div class="mt-0.5 text-xs text-gray-400 dark:text-gray-500">
                                    {{ __('app.stock_fees.per_share') }}
                                </div>
                            @endif
                        </div>
                    </div>

                    <button
                        type="button"
                        x-on:click="window.copyToClipboard(@js($copy($results->breakEvenSharePrice, 4))).then(() => { copied = true; setTimeout(() => copied = false, 1500); })"
                        class="inline-flex shrink-0 items-center gap-2 rounded-xl border border-primary-300 bg-white px-4 py-2.5 text-sm font-medium text-primary-700 transition hover:bg-primary-100 dark:border-primary-500/40 dark:bg-white/5 dark:text-primary-300 dark:hover:bg-primary-500/20"
                        :disabled="@js($results->breakEvenSharePrice === null)"
                        :class="{ 'opacity-40 pointer-events-none': @js($results->breakEvenSharePrice === null) }"
                        :title="copied ? @js(__('app.stock_fees.copied')) : @js(__('app.stock_fees.copy'))"
                    >
                        <x-heroicon-o-clipboard x-show="!copied" class="h-4 w-4" />
                        <x-heroicon-o-check-circle x-show="copied" class="h-4 w-4 text-success-500" />
                        <span x-text="copied ? @js(__('app.stock_fees.copied')) : @js(__('app.stock_fees.copy'))"></span>
                    </button>
                </div>
            </div>
        </div>
    </x-filament::section>
</x-filament-panels::page>
