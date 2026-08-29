<?php

namespace Tests\Feature;

use App\Filament\Widgets\TopProfitStocksChart;
use App\Models\Stock;
use App\Models\Trade;
use App\Models\TradeTrack;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TopProfitStocksChartTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_aggregates_profit_per_stock_across_all_open_trades(): void
    {
        $stockA = Stock::create([
            'name' => 'Alpha',
            'code' => 'A',
            'market' => 'EGX',
            'price' => 100,
        ]);

        $stockB = Stock::create([
            'name' => 'Beta',
            'code' => 'B',
            'market' => 'EGX',
            'price' => 80,
        ]);

        $tradeA1 = Trade::create([
            'stock_id' => $stockA->id,
            'amount' => 10,
            'status' => 'open',
        ]);

        TradeTrack::create([
            'trade_id' => $tradeA1->id,
            'amount' => 250,
            'date' => now(),
            'type' => 'profit',
        ]);

        $tradeA2 = Trade::create([
            'stock_id' => $stockA->id,
            'amount' => 4,
            'status' => 'open',
        ]);

        TradeTrack::create([
            'trade_id' => $tradeA2->id,
            'amount' => -100,
            'date' => now(),
            'type' => 'sell',
        ]);

        $tradeB1 = Trade::create([
            'stock_id' => $stockB->id,
            'amount' => 5,
            'status' => 'open',
        ]);

        TradeTrack::create([
            'trade_id' => $tradeB1->id,
            'amount' => 100,
            'date' => now(),
            'type' => 'profit',
        ]);

        $widget = new TopProfitStocksChart();
        $data = $widget->getTopProfitStocksData();

        $this->assertSame(['A', 'B'], $data['labels']);
        $this->assertSame([1550.0, 500.0], $data['datasets'][0]['data']);
    }
}
