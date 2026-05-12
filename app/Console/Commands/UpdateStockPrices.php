<?php

namespace App\Console\Commands;

use App\Models\Stock;
use App\Services\StockPriceService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Throwable;

class UpdateStockPrices extends Command
{
    protected $signature = 'stocks:update-prices
        {--market= : Only update stocks from this market}
        {--code=* : Only update these stock codes}
        {--provider=tradingview : Price provider: tradingview, mubasher, or stooq}
        {--delay=250 : Milliseconds to wait between requests}
        {--dry-run : Show fetched prices without saving them}';

    protected $description = 'Update stocks last prices from a free public market data source.';

    public function handle(StockPriceService $stockPriceService): int
    {
        $this->recordLastRunDateTime();

        $provider = strtolower((string) $this->option('provider'));

        if (! in_array($provider, $stockPriceService->providers(), true)) {
            $this->error('Unsupported provider. Use tradingview, mubasher, or stooq.');

            return self::FAILURE;
        }

        $query = Stock::query()->orderBy('code');

        if ($market = $this->option('market')) {
            $query->where('market', $market);
        }

        $codes = array_map(
            fn (string $code): string => strtoupper(trim($code)),
            (array) $this->option('code'),
        );

        $codes = array_filter($codes);

        if ($codes !== []) {
            $query->whereIn('code', $codes);
        }

        /** @var \Illuminate\Database\Eloquent\Collection<int, Stock> $stocks */
        $stocks = $query->get();

        if ($stocks->isEmpty()) {
            $this->warn('No stocks found for the selected filters.');

            return self::SUCCESS;
        }

        $updated = 0;
        $unchanged = 0;
        $failed = 0;
        $dryRun = (bool) $this->option('dry-run');
        $delay = max(0, (int) $this->option('delay'));

        $this->info("Updating {$stocks->count()} stock prices using {$provider}...");

        foreach ($stocks as $stock) {
            try {
                $price = $stockPriceService->fetch($stock, $provider);

                if ($price === null) {
                    $failed++;
                    $this->warn("{$stock->code}: price not found.");
                    $this->sleep($delay);

                    continue;
                }

                if ((float) $stock->price === $price) {
                    $unchanged++;
                    $this->line("{$stock->code}: unchanged at {$price}");
                    $this->sleep($delay);

                    continue;
                }

                $this->line("{$stock->code}: {$stock->price} -> {$price}");

                if (! $dryRun) {
                    $stock->update(['price' => $price]);
                }

                $updated++;
            } catch (Throwable $exception) {
                $failed++;
                $this->warn("{$stock->code}: {$exception->getMessage()}");
            }

            $this->sleep($delay);
        }

        $mode = $dryRun ? 'Dry run finished' : 'Price update finished';
        $this->info("{$mode}. Updated: {$updated}. Unchanged: {$unchanged}. Failed: {$failed}.");

        return $failed > 0 ? self::FAILURE : self::SUCCESS;
    }

    private function sleep(int $milliseconds): void
    {
        if ($milliseconds > 0) {
            usleep($milliseconds * 1000);
        }
    }

    private function recordLastRunDateTime(): void
    {
        $directory = storage_path('app/stock-price-updates');

        File::ensureDirectoryExists($directory);
        File::put("{$directory}/last-run-at.txt", now()->format('d-m-Y h:i:s a'));
    }
}
