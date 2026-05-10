<div
    @if ($result['running'] ?? false) wire:poll.2s="refreshStockPriceUpdateResult" @endif
    class="space-y-4 pr-1"
    style="max-height: min(70vh, 42rem); overflow-y: auto; overscroll-behavior: contain;"
>
    <div @class([
        'flex items-center justify-between gap-3 rounded-lg border p-3 text-sm',
        'border-info-200 bg-info-50 text-info-700 dark:border-info-800 dark:bg-info-950 dark:text-info-300' => $result['running'] ?? false,
        'border-success-200 bg-success-50 text-success-700 dark:border-success-800 dark:bg-success-950 dark:text-success-300' => ! ($result['running'] ?? false) && ! ($result['stopped'] ?? false) && (($result['exitCode'] ?? 1) === 0),
        'border-warning-200 bg-warning-50 text-warning-700 dark:border-warning-800 dark:bg-warning-950 dark:text-warning-300' => $result['stopped'] ?? false,
        'border-danger-200 bg-danger-50 text-danger-700 dark:border-danger-800 dark:bg-danger-950 dark:text-danger-300' => ! ($result['running'] ?? false) && ! ($result['stopped'] ?? false) && (($result['exitCode'] ?? 1) !== 0),
    ]) style="display: flex; align-items: center; justify-content: space-between; gap: 0.75rem;">
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
            <dd class="mt-1 text-gray-950 dark:text-white">{{ $result['startedAt'] ?? '-' }}</dd>
        </div>

        <div>
            <dt class="font-medium text-gray-500 dark:text-gray-400">Finished</dt>
            <dd class="mt-1 text-gray-950 dark:text-white">{{ $result['finishedAt'] ?? 'Still running' }}</dd>
        </div>

        <div>
            <dt class="font-medium text-gray-500 dark:text-gray-400">Exit code</dt>
            <dd class="mt-1 text-gray-950 dark:text-white">{{ $result['exitCode'] ?? 'Pending' }}</dd>
        </div>

        <div>
            <dt class="font-medium text-gray-500 dark:text-gray-400">Command</dt>
            <dd class="mt-1 break-words font-mono text-xs text-gray-950 dark:text-white">
                {{ $result['command'] ?? 'php artisan stocks:update-prices' }}
            </dd>
        </div>
    </dl>

    <div>
        <div class="mb-2 text-sm font-medium text-gray-500 dark:text-gray-400">Output</div>
        <pre class="max-h-96 overflow-auto rounded-lg bg-gray-950 p-4 text-xs leading-6 text-gray-100 whitespace-pre-wrap">{{ $result['output'] ?? 'No output available.' }}</pre>
    </div>
</div>
