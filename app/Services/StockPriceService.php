<?php

namespace App\Services;

use App\Models\Stock;
use Illuminate\Support\Facades\Http;
use InvalidArgumentException;

class StockPriceService
{
    /**
     * @return array<int, string>
     */
    public function providers(): array
    {
        return ['tradingview', 'mubasher', 'stooq'];
    }

    public function fetch(Stock $stock, string $provider = 'tradingview'): ?float
    {
        return match (strtolower($provider)) {
            'tradingview' => $this->fetchFromTradingView($stock),
            'mubasher' => $this->fetchFromMubasher($stock),
            'stooq' => $this->fetchFromStooq($stock),
            default => throw new InvalidArgumentException('Unsupported provider. Use tradingview, mubasher, or stooq.'),
        };
    }

    private function fetchFromTradingView(Stock $stock): ?float
    {
        $market = $this->tradingViewMarket($stock);
        $exchange = $this->tradingViewExchange($stock);
        $symbol = strtoupper($stock->code);

        $response = Http::timeout(15)
            ->retry(2, 500)
            ->withHeaders([
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
                'Origin' => 'https://www.tradingview.com',
                'Referer' => 'https://www.tradingview.com/',
                'User-Agent' => 'Mozilla/5.0 (compatible; InvestingApp/1.0)',
            ])
            ->post("https://scanner.tradingview.com/{$market}/scan", [
                'symbols' => [
                    'tickers' => ["{$exchange}:{$symbol}"],
                    'query' => [
                        'types' => [],
                    ],
                ],
                'columns' => ['close'],
            ])
            ->throw()
            ->json();

        $price = $response['data'][0]['d'][0] ?? null;

        return $this->normalizePrice($price);
    }

    private function fetchFromMubasher(Stock $stock): ?float
    {
        $market = strtoupper($stock->market ?: 'EGX');
        $code = strtoupper($stock->code);
        $url = "https://english.mubasher.info/markets/{$market}/stocks/{$code}";

        $html = Http::timeout(15)
            ->retry(2, 500)
            ->withHeaders([
                'User-Agent' => 'Mozilla/5.0 (compatible; InvestingApp/1.0)',
            ])
            ->get($url)
            ->throw()
            ->body();

        return $this->extractMubasherPrice($html, $code);
    }

    private function fetchFromStooq(Stock $stock): ?float
    {
        $symbol = strtolower($stock->code);

        if (strtoupper($stock->market) === 'US' && ! str_contains($symbol, '.')) {
            $symbol .= '.us';
        }

        $csv = Http::timeout(15)
            ->retry(2, 500)
            ->get('https://stooq.pl/q/l/', [
                's' => $symbol,
                'f' => 'sd2t2ohlcv',
                'h' => '',
                'e' => 'csv',
            ])
            ->throw()
            ->body();

        $rows = array_map('str_getcsv', array_filter(explode("\n", trim($csv))));

        if (count($rows) < 2) {
            return null;
        }

        $headers = array_map('strtolower', $rows[0]);
        $values = array_combine($headers, $rows[1]);

        if ($values === false) {
            return null;
        }

        return $this->normalizePrice($values['close'] ?? null);
    }

    private function tradingViewMarket(Stock $stock): string
    {
        return match (strtoupper($stock->market)) {
            'EGX', 'EGYPT' => 'egypt',
            'US', 'USA', 'NASDAQ', 'NYSE', 'AMEX' => 'america',
            default => strtolower($stock->market ?: 'egypt'),
        };
    }

    private function tradingViewExchange(Stock $stock): string
    {
        return match (strtoupper($stock->market)) {
            'EGX', 'EGYPT' => 'EGX',
            'NASDAQ' => 'NASDAQ',
            'NYSE' => 'NYSE',
            'AMEX' => 'AMEX',
            default => strtoupper($stock->market ?: 'EGX'),
        };
    }

    private function extractMubasherPrice(string $html, string $code): ?float
    {
        $text = preg_replace('/<(script|style)\b[^>]*>.*?<\/\1>/is', '', $html) ?? $html;
        $text = html_entity_decode(strip_tags($text), ENT_QUOTES | ENT_HTML5);
        $lines = array_values(array_filter(array_map(
            fn (string $line): string => trim(preg_replace('/\s+/', ' ', $line) ?? $line),
            preg_split('/\R+/', $text) ?: [],
        )));

        foreach ($lines as $index => $line) {
            if (! str_contains(strtoupper($line), '(' . strtoupper($code) . ')')) {
                continue;
            }

            for ($offset = 1; $offset <= 20; $offset++) {
                $price = $this->normalizePrice($lines[$index + $offset] ?? null);

                if ($price !== null) {
                    return $price;
                }
            }
        }

        return null;
    }

    private function normalizePrice(mixed $value): ?float
    {
        if ($value === null) {
            return null;
        }

        $normalized = str_replace(',', '', trim((string) $value));

        if (! preg_match('/^\d+(?:\.\d+)?$/', $normalized)) {
            return null;
        }

        return (float) $normalized;
    }
}
