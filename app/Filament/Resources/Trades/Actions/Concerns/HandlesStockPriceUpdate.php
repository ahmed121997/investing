<?php

namespace App\Filament\Resources\Trades\Actions\Concerns;

use Filament\Notifications\Notification;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use RuntimeException;
use Throwable;

trait HandlesStockPriceUpdate
{
    public ?array $stockPriceUpdateResult = null;

    public function startStockPriceUpdate(array $data): void
    {
        $parameters = [
            '--provider' => $data['provider'],
            '--delay' => (int) $data['delay'],
        ];

        if (filled($data['market'] ?? null)) {
            $parameters['--market'] = $data['market'];
        }

        if (! empty($data['codes'])) {
            $parameters['--code'] = $data['codes'];
        }

        if ($data['dry_run'] ?? false) {
            $parameters['--dry-run'] = true;
        }

        $runId = (string) Str::uuid();
        $directory = storage_path('app/stock-price-updates');
        $logPath = "{$directory}/{$runId}.log";
        $pidPath = "{$directory}/{$runId}.pid";
        $statusPath = "{$directory}/{$runId}.status";
        $stopPath = "{$directory}/{$runId}.stop";
        $startedAt = now();
        $command = $this->formatStockPriceUpdateCommandForDisplay($parameters);

        try {
            File::ensureDirectoryExists($directory);
            File::put($logPath, "Starting {$command}\n\n");

            $pid = $this->runStockPriceUpdateCommandInBackground(
                parameters: $parameters,
                logPath: $logPath,
                statusPath: $statusPath,
                stopPath: $stopPath,
            );

            File::put($pidPath, (string) $pid);

            $this->stockPriceUpdateResult = [
                'command' => $command,
                'exitCode' => null,
                'finishedAt' => null,
                'logPath' => $logPath,
                'output' => File::get($logPath),
                'pid' => $pid,
                'pidPath' => $pidPath,
                'running' => true,
                'startedAt' => $startedAt->toDateTimeString(),
                'statusPath' => $statusPath,
                'stopPath' => $stopPath,
                'stopped' => false,
            ];

            Notification::make()
                ->title('Stock price update started')
                ->info()
                ->send();
        } catch (Throwable $exception) {
            $this->stockPriceUpdateResult = [
                'command' => $command,
                'exitCode' => 1,
                'finishedAt' => now()->toDateTimeString(),
                'output' => $exception->getMessage(),
                'running' => false,
                'startedAt' => $startedAt->toDateTimeString(),
                'stopped' => false,
            ];

            Notification::make()
                ->title('Stock price update could not start')
                ->danger()
                ->send();
        }

        $this->replaceMountedAction('stockPriceUpdateDetails');
    }

    public function refreshStockPriceUpdateResult(): void
    {
        if (! ($this->stockPriceUpdateResult['running'] ?? false)) {
            return;
        }

        $this->refreshStockPriceUpdateOutput();

        $statusPath = $this->stockPriceUpdateResult['statusPath'] ?? null;

        if (! $statusPath || ! File::exists($statusPath)) {
            return;
        }

        $exitCode = (int) trim(File::get($statusPath));

        $this->stockPriceUpdateResult['exitCode'] = $exitCode;
        $this->stockPriceUpdateResult['finishedAt'] = now()
            ->setTimestamp(File::lastModified($statusPath))
            ->toDateTimeString();
        $this->stockPriceUpdateResult['running'] = false;

        Notification::make()
            ->title($exitCode === 0 ? 'Stock price update finished' : 'Stock price update finished with errors')
            ->{$exitCode === 0 ? 'success' : 'danger'}()
            ->send();
    }

    public function stopStockPriceUpdate(): void
    {
        if (! ($this->stockPriceUpdateResult['running'] ?? false)) {
            return;
        }

        $pid = (int) ($this->stockPriceUpdateResult['pid'] ?? 0);
        $logPath = $this->stockPriceUpdateResult['logPath'] ?? null;
        $statusPath = $this->stockPriceUpdateResult['statusPath'] ?? null;
        $stopPath = $this->stockPriceUpdateResult['stopPath'] ?? null;

        if ($stopPath) {
            File::put($stopPath, now()->toDateTimeString());
        }

        if ($logPath) {
            File::append($logPath, "\nStopped by user.\n");
        }

        if ($pid > 0) {
            $this->terminateStockPriceUpdateProcess($pid);
        }

        if ($statusPath) {
            File::put($statusPath, '143');
        }

        $this->refreshStockPriceUpdateOutput();

        $this->stockPriceUpdateResult['exitCode'] = 143;
        $this->stockPriceUpdateResult['finishedAt'] = now()->toDateTimeString();
        $this->stockPriceUpdateResult['running'] = false;
        $this->stockPriceUpdateResult['stopped'] = true;

        Notification::make()
            ->title('Stock price update stopped')
            ->warning()
            ->send();
    }

    private function refreshStockPriceUpdateOutput(): void
    {
        $logPath = $this->stockPriceUpdateResult['logPath'] ?? null;

        if ($logPath && File::exists($logPath)) {
            $this->stockPriceUpdateResult['output'] = File::get($logPath);
        }
    }

    private function runStockPriceUpdateCommandInBackground(
        array $parameters,
        string $logPath,
        string $statusPath,
        string $stopPath,
    ): int {
        if (! function_exists('exec')) {
            throw new RuntimeException('The exec() function is disabled, so the command cannot run in the background.');
        }

        $arguments = $this->formatStockPriceUpdateCommandArguments($parameters);
        $script = sprintf(
            '%s %s stocks:update-prices %s >> %s 2>&1; code=$?; if [ ! -f %s ]; then printf %%s "$code" > %s; fi',
            escapeshellarg(PHP_BINARY),
            escapeshellarg(base_path('artisan')),
            implode(' ', $arguments),
            escapeshellarg($logPath),
            escapeshellarg($stopPath),
            escapeshellarg($statusPath),
        );

        $command = sprintf('setsid sh -c %s > /dev/null 2>&1 & echo $!', escapeshellarg($script));
        $output = [];
        $resultCode = 0;

        exec($command, $output, $resultCode);

        $pid = (int) ($output[0] ?? 0);

        if ($resultCode !== 0 || $pid <= 0) {
            throw new RuntimeException('The background command could not be started.');
        }

        return $pid;
    }

    private function terminateStockPriceUpdateProcess(int $pid): void
    {
        if (! function_exists('exec')) {
            return;
        }

        exec(sprintf('kill -TERM -%1$d 2>/dev/null || kill -TERM %1$d 2>/dev/null', $pid));
    }

    private function formatStockPriceUpdateCommandForDisplay(array $parameters): string
    {
        $parts = ['php', 'artisan', 'stocks:update-prices'];

        return implode(' ', [
            ...$parts,
            ...$this->formatStockPriceUpdateCommandArguments($parameters),
        ]);
    }

    private function formatStockPriceUpdateCommandArguments(array $parameters): array
    {
        $arguments = [];

        foreach ($parameters as $option => $value) {
            if ($value === true) {
                $arguments[] = $option;

                continue;
            }

            foreach ((array) $value as $item) {
                $arguments[] = $option.'='.escapeshellarg((string) $item);
            }
        }

        return $arguments;
    }
}
