<x-filament-widgets::widget>
    <x-filament::section>
        <x-slot name="heading">
            {{ __('app.dashboard.deposits_vs_withdrawals') }}
        </x-slot>

        <div class="w-full space-y-8">
            <!-- Line Chart -->
            <div>
                <h3 class="text-lg font-semibold mb-4 text-gray-700">{{ __('app.dashboard.trend_analysis') }}</h3>
                <canvas id="depositWithdrawalLineChart" style="max-height: 300px;"></canvas>
            </div>

            <!-- Bar Chart -->
            <div>
                <h3 class="text-lg font-semibold mb-4 text-gray-700">{{ __('app.dashboard.monthly_comparison') }}</h3>
                <canvas id="depositWithdrawalBarChart" style="max-height: 300px;"></canvas>
            </div>
        </div>

        @php $depositsLabel = __('app.dashboard.deposits'); $withdrawalsLabel = __('app.dashboard.withdrawals'); @endphp

        @push('scripts')
            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const data = @json($this->getData());

                    // Line Chart
                    const lineCtx = document.getElementById('depositWithdrawalLineChart');
                    if (lineCtx) {
                        new Chart(lineCtx, {
                            type: 'line',
                            data: {
                                labels: data.months,
                                datasets: [
                                    {
                                        label: @json($depositsLabel),
                                        data: data.deposits,
                                        borderColor: '#22c55e',
                                        backgroundColor: 'rgba(34, 197, 94, 0.1)',
                                        tension: 0.3,
                                        fill: true,
                                        borderWidth: 2,
                                        pointRadius: 5,
                                        pointBackgroundColor: '#22c55e',
                                        pointHoverRadius: 7
                                    },
                                    {
                                        label: @json($withdrawalsLabel),
                                        data: data.withdrawals,
                                        borderColor: '#ef4444',
                                        backgroundColor: 'rgba(239, 68, 68, 0.1)',
                                        tension: 0.3,
                                        fill: true,
                                        borderWidth: 2,
                                        pointRadius: 5,
                                        pointBackgroundColor: '#ef4444',
                                        pointHoverRadius: 7
                                    }
                                ]
                            },
                            options: {
                                responsive: true,
                                maintainAspectRatio: true,
                                plugins: {
                                    legend: {
                                        position: 'top',
                                        labels: {
                                            padding: 15,
                                            font: {
                                                size: 12,
                                                weight: 'bold'
                                            }
                                        }
                                    },
                                    title: {
                                        display: false
                                    }
                                },
                                scales: {
                                    y: {
                                        beginAtZero: true,
                                        ticks: {
                                            callback: function(value) {
                                                return '$' + value.toLocaleString();
                                            }
                                        }
                                    }
                                }
                            }
                        });
                    }

                    // Bar Chart
                    const barCtx = document.getElementById('depositWithdrawalBarChart');
                    if (barCtx) {
                        new Chart(barCtx, {
                            type: 'bar',
                            data: {
                                labels: data.months,
                                datasets: [
                                    {
                                        label: @json($depositsLabel),
                                        data: data.deposits,
                                        backgroundColor: '#22c55e',
                                        borderColor: '#16a34a',
                                        borderWidth: 1,
                                        borderRadius: 4
                                    },
                                    {
                                        label: @json($withdrawalsLabel),
                                        data: data.withdrawals,
                                        backgroundColor: '#ef4444',
                                        borderColor: '#dc2626',
                                        borderWidth: 1,
                                        borderRadius: 4
                                    }
                                ]
                            },
                            options: {
                                responsive: true,
                                maintainAspectRatio: true,
                                plugins: {
                                    legend: {
                                        position: 'top',
                                        labels: {
                                            padding: 15,
                                            font: {
                                                size: 12,
                                                weight: 'bold'
                                            }
                                        }
                                    },
                                    title: {
                                        display: false
                                    }
                                },
                                scales: {
                                    y: {
                                        beginAtZero: true,
                                        ticks: {
                                            callback: function(value) {
                                                return '$' + value.toLocaleString();
                                            }
                                        }
                                    }
                                }
                            }
                        });
                    }
                });
            </script>
        @endpush
    </x-filament::section>
</x-filament-widgets::widget>
