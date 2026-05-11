<div
    @if ($result['running'] ?? false) wire:poll.2s="refreshStockPriceUpdateResult" @endif
    class="max-w-full space-y-4 overflow-x-hidden pr-0 sm:pr-1"
    style="max-height: min(75dvh, 42rem); overflow-y: auto; overscroll-behavior: contain;"
>
    <div @class([
        'flex flex-col items-stretch justify-between gap-3 rounded-lg border p-3 text-sm sm:flex-row sm:items-center',
        'border-info-200 bg-info-50 text-info-700 dark:border-info-800 dark:bg-info-950 dark:text-info-300' => $result['running'] ?? false,
        'border-success-200 bg-success-50 text-success-700 dark:border-success-800 dark:bg-success-950 dark:text-success-300' => ! ($result['running'] ?? false) && ! ($result['stopped'] ?? false) && (($result['exitCode'] ?? 1) === 0),
        'border-warning-200 bg-warning-50 text-warning-700 dark:border-warning-800 dark:bg-warning-950 dark:text-warning-300' => $result['stopped'] ?? false,
        'border-danger-200 bg-danger-50 text-danger-700 dark:border-danger-800 dark:bg-danger-950 dark:text-danger-300' => ! ($result['running'] ?? false) && ! ($result['stopped'] ?? false) && (($result['exitCode'] ?? 1) !== 0),
    ])>
        <span style="display: inline-block">
            @if ($result['running'] ?? false)
                Running...
            @elseif ($result['stopped'] ?? false)
                Stopped by user.
            @elseif (($result['exitCode'] ?? 1) === 0)
                Finished successfully.
            @else
                Finished with errors.
            @endif
        </span>

        @if ($result['running'] ?? false)
            <x-filament::button
                type="button"
                color="danger"
                class="w-full sm:w-auto"
                wire:click="stopStockPriceUpdate"
                wire:loading.remove
                wire:loading.attr="disabled"
                wire:target="stopStockPriceUpdate"
            >
                Stop command
            </x-filament::button>
        @endif
    </div>

    <dl class="grid gap-3 text-sm sm:grid-cols-2">
        <div>
            <dt class="font-medium text-gray-500 dark:text-gray-400">Started</dt>
            <dd class="mt-1 break-words text-gray-950 dark:text-white">{{ $result['startedAt'] ?? '-' }}</dd>
        </div>

        <div>
            <dt class="font-medium text-gray-500 dark:text-gray-400">Finished</dt>
            <dd class="mt-1 break-words text-gray-950 dark:text-white">{{ $result['finishedAt'] ?? 'Still running' }}</dd>
        </div>

        <div>
            <dt class="font-medium text-gray-500 dark:text-gray-400">Exit code</dt>
            <dd class="mt-1 break-words text-gray-950 dark:text-white">{{ $result['exitCode'] ?? 'Pending' }}</dd>
        </div>

        <div>
            <dt class="font-medium text-gray-500 dark:text-gray-400">Command</dt>
            <dd class="mt-1 break-words font-mono text-xs text-gray-950 dark:text-white [overflow-wrap:anywhere]">
                {{ $result['command'] ?? 'php artisan stocks:update-prices' }}
            </dd>
        </div>
    </dl>

    <div>
        <div class="mb-2 text-sm font-medium text-gray-500 dark:text-gray-400">Output</div>
        <pre class="max-h-80 max-w-full overflow-auto rounded-lg bg-gray-950 p-3 text-xs leading-6 whitespace-pre-wrap break-words text-gray-100 sm:max-h-96 sm:p-4 [overflow-wrap:anywhere]">{{ $result['output'] ?? 'No output available.' }}</pre>
    </div>
</div>
