<?php

namespace App\Console\Commands;

use App\Models\Sector;
use App\Models\Stock;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use RuntimeException;
use SimpleXMLElement;
use ZipArchive;

class UpdateStocksSector extends Command
{
    protected $signature = 'stocks:update-sectors
        {--file=sectors.xlsx : Excel file path, relative to storage/app/private or absolute}
        {--dry-run : Show what would be updated without saving changes}';

    protected $description = 'Update stocks table with sector information from Excel file';

    public function handle(): int
    {
        $path = $this->resolvePath((string) $this->option('file'));

        if (! file_exists($path)) {
            $this->error("File not found: {$path}");

            return self::FAILURE;
        }

        $rows = $this->readFirstWorksheet($path);
        $dryRun = (bool) $this->option('dry-run');
        $updated = 0;
        $unchanged = 0;
        $missingStocks = 0;
        $missingSectors = 0;
        $skipped = 0;

        DB::transaction(function () use ($rows, $dryRun, &$updated, &$unchanged, &$missingStocks, &$missingSectors, &$skipped): void {
            foreach ($rows as $row) {
                $stockName = $this->normalizeText($row['stock_name'] ?? null);
                $sectorName = $this->normalizeText($row['sector_name'] ?? null);

                if ($stockName === '' || $sectorName === '') {
                    $skipped++;

                    continue;
                }

                $stock = Stock::query()
                    ->where('name', 'like', "%{$stockName}%")
                    ->first();

                if (! $stock) {
                    $missingStocks++;
                    $this->warn("Stock not found: {$stockName}");

                    continue;
                }
                $sector = Sector::query()
                    ->whereRaw('LOWER(name_ar) = ?', [mb_strtolower($sectorName)])
                    ->orWhereRaw('LOWER(name) = ?', [mb_strtolower($sectorName)])
                    ->first();

                if (! $sector) {
                    $missingSectors++;
                    $this->warn("Sector not found: {$sectorName}");

                    continue;
                }

                if ((int) $stock->sector_id === (int) $sector->id) {
                    $unchanged++;

                    continue;
                }

                $this->line("{$stock->name}: {$sector->name_ar}");

                if (! $dryRun) {
                    $stock->update(['sector_id' => $sector->id]);
                }

                $updated++;
            }
        });

        $mode = $dryRun ? 'Dry run finished' : 'Sector import finished';
        $this->info("{$mode}. Updated: {$updated}. Unchanged: {$unchanged}. Missing stocks: {$missingStocks}. Missing sectors: {$missingSectors}. Skipped: {$skipped}.");

        return ($missingStocks > 0 || $missingSectors > 0) ? self::FAILURE : self::SUCCESS;
    }

    private function resolvePath(string $file): string
    {
        if (str_starts_with($file, '/')) {
            return $file;
        }

        $file = ltrim($file, '/');

        if (str_starts_with($file, 'storage/app/private/')) {
            return base_path($file);
        }

        if (str_starts_with($file, 'app/private/')) {
            return storage_path($file);
        }

        return Storage::disk('local')->path($file);
    }

    /**
     * @return array<int, array{stock_name: string|null, sector_name: string|null}>
     */
    private function readFirstWorksheet(string $path): array
    {
        $zip = new ZipArchive;

        if ($zip->open($path) !== true) {
            throw new RuntimeException("Unable to open Excel file: {$path}");
        }

        $sheetXml = $zip->getFromName('xl/worksheets/sheet1.xml');

        if ($sheetXml === false) {
            throw new RuntimeException('Unable to find the first worksheet in the Excel file.');
        }

        $sharedStrings = $this->readSharedStrings($zip);
        $sheet = simplexml_load_string($sheetXml);

        if (! $sheet instanceof SimpleXMLElement) {
            throw new RuntimeException('Unable to parse worksheet XML.');
        }

        $headers = [];
        $rows = [];
        $isHeaderRow = true;

        foreach ($sheet->sheetData->row as $row) {
            $values = [];

            foreach ($row->c as $cell) {
                $column = preg_replace('/\d+/', '', (string) $cell['r']);
                $values[$column] = $this->cellValue($cell, $sharedStrings);
            }

            if ($isHeaderRow) {
                $headers = $this->mapHeaders($values);
                $isHeaderRow = false;

                continue;
            }

            $rows[] = [
                'stock_name' => $values[$headers['stock_name'] ?? ''] ?? null,
                'sector_name' => $values[$headers['sector_name'] ?? ''] ?? null,
            ];
        }

        $zip->close();

        return $rows;
    }

    /**
     * @return array<int, string>
     */
    private function readSharedStrings(ZipArchive $zip): array
    {
        $xml = $zip->getFromName('xl/sharedStrings.xml');

        if ($xml === false) {
            return [];
        }

        $sharedStrings = simplexml_load_string($xml);

        if (! $sharedStrings instanceof SimpleXMLElement) {
            return [];
        }

        $strings = [];

        foreach ($sharedStrings->si as $stringItem) {
            $parts = [];

            if (isset($stringItem->t)) {
                $parts[] = (string) $stringItem->t;
            }

            foreach ($stringItem->r as $run) {
                $parts[] = (string) $run->t;
            }

            $strings[] = implode('', $parts);
        }

        return $strings;
    }

    /**
     * @param  array<int, string>  $sharedStrings
     */
    private function cellValue(SimpleXMLElement $cell, array $sharedStrings): ?string
    {
        $type = (string) $cell['t'];

        if ($type === 'inlineStr') {
            return isset($cell->is->t) ? (string) $cell->is->t : null;
        }

        $value = isset($cell->v) ? (string) $cell->v : null;

        if ($type === 's' && $value !== null) {
            return $sharedStrings[(int) $value] ?? null;
        }

        return $value;
    }

    /**
     * @param  array<string, string|null>  $values
     * @return array{stock_name?: string, sector_name?: string}
     */
    private function mapHeaders(array $values): array
    {
        $headers = [];

        foreach ($values as $column => $header) {
            $normalized = $this->normalizeText($header);

            if (in_array($normalized, ['اسم الشركة', 'name', 'company name', 'stock name'], true)) {
                $headers['stock_name'] = $column;
            }

            if (in_array($normalized, ['القطاع', 'sector', 'sector name'], true)) {
                $headers['sector_name'] = $column;
            }
        }

        return $headers + [
            'stock_name' => 'A',
            'sector_name' => 'B',
        ];
    }

    private function normalizeText(mixed $value): string
    {
        return preg_replace('/\s+/u', ' ', trim((string) $value)) ?? '';

    }
}
