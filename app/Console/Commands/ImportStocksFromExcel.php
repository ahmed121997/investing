<?php

namespace App\Console\Commands;

use App\Models\Stock;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use RuntimeException;
use SimpleXMLElement;
use ZipArchive;

class ImportStocksFromExcel extends Command
{
    protected $signature = 'stocks:import
        {file=EGX_Stocks_7-5-2026.xlsx : Excel file path, relative to storage/app/private or absolute}
        {--market=EGx : Market value for new stocks}';

    protected $description = 'Import EGX stocks from an Excel .xlsx file, creating missing stocks and updating prices for existing codes.';

    public function handle(): int
    {
        $path = $this->resolvePath($this->argument('file'));

        if (! file_exists($path)) {
            $this->error("File not found: {$path}");

            return self::FAILURE;
        }

        $rows = $this->readFirstWorksheet($path);
        $created = 0;
        $updated = 0;
        $skipped = 0;

        DB::transaction(function () use ($rows, &$created, &$updated, &$skipped): void {
            foreach ($rows as $row) {
                $name = trim((string) ($row['name'] ?? ''));
                $code = strtoupper(trim((string) ($row['code'] ?? '')));
                $price = $this->normalizePrice($row['price'] ?? null);

                if ($name === '' || $code === '' || $price === null) {
                    $skipped++;

                    continue;
                }

                $stock = Stock::query()->where('code', $code)->first();

                if ($stock) {
                    $stock->update(['price' => $price]);
                    $updated++;

                    continue;
                }

                Stock::query()->create([
                    'name' => $name,
                    'code' => $code,
                    'market' => (string) $this->option('market'),
                    'price' => $price,
                ]);

                $created++;
            }
        });

        $this->info("Stocks import finished. Created: {$created}. Updated prices: {$updated}. Skipped: {$skipped}.");

        return self::SUCCESS;
    }

    private function resolvePath(string $file): string
    {
        if (str_starts_with($file, '/')) {
            return $file;
        }

        return Storage::disk('local')->path($file);
    }

    /**
     * @return array<int, array{name: string|null, code: string|null, price: string|null}>
     */
    private function readFirstWorksheet(string $path): array
    {
        $zip = new ZipArchive();

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
                'name' => $values[$headers['name'] ?? ''] ?? null,
                'code' => $values[$headers['code'] ?? ''] ?? null,
                'price' => $values[$headers['price'] ?? ''] ?? null,
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
     * @return array{name?: string, code?: string, price?: string}
     */
    private function mapHeaders(array $values): array
    {
        $headers = [];

        foreach ($values as $column => $header) {
            $normalized = trim((string) $header);

            if (in_array($normalized, ['اسم الشركة', 'name', 'company name'], true)) {
                $headers['name'] = $column;
            }

            if (in_array($normalized, ['الرمز', 'code', 'symbol'], true)) {
                $headers['code'] = $column;
            }

            if (in_array($normalized, ['السعر الأخير', 'price', 'last price'], true)) {
                $headers['price'] = $column;
            }
        }

        return $headers + [
            'name' => 'A',
            'code' => 'B',
            'price' => 'C',
        ];
    }

    private function normalizePrice(mixed $value): ?float
    {
        if ($value === null) {
            return null;
        }

        $normalized = str_replace(',', '', trim((string) $value));

        if ($normalized === '' || ! is_numeric($normalized)) {
            return null;
        }

        return (float) $normalized;
    }
}
