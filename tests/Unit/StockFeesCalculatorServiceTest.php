<?php

namespace Tests\Unit;

use App\Models\StockFeeSetting;
use App\Services\StockFeesCalculatorService;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class StockFeesCalculatorServiceTest extends TestCase
{
    private StockFeesCalculatorService $service;

    protected function setUp(): void
    {
        parent::setUp();

        $settings = new StockFeeSetting([
            'thunder_percentage' => 0.25,
            'thunder_fixed_fee' => 10,
            'exchange_fee_percentage' => 0.15,
            'egx_fee_percentage' => 0.1,
            'misr_clearing_fee_percentage' => 0.05,
            'fra_fee_percentage' => 0.02,
        ]);

        $this->service = new StockFeesCalculatorService($settings);
    }

    #[Test]
    public function it_calculates_trade_value_directly(): void
    {
        $result = $this->service->calculate([
            'input_method' => 'trade_value',
            'trade_value' => 1000,
            'thunder_x' => false,
        ]);

        $this->assertSame(1000.0, $result['trade_value']);
    }

    #[Test]
    public function it_calculates_trade_value_from_quantity_and_price(): void
    {
        $result = $this->service->calculate([
            'input_method' => 'quantity',
            'quantity' => 100,
            'share_price' => 50,
            'thunder_x' => false,
        ]);

        $this->assertSame(5000.0, $result['trade_value']);
    }

    #[Test]
    public function it_waives_thunder_commission_for_thunder_x_members(): void
    {
        $result = $this->service->calculate([
            'input_method' => 'trade_value',
            'trade_value' => 1000,
            'thunder_x' => true,
        ]);

        $this->assertSame(0.0, $result['thunder_commission']);
    }

    #[Test]
    public function it_applies_fixed_fee_and_percentage_for_non_members(): void
    {
        $result = $this->service->calculate([
            'input_method' => 'trade_value',
            'trade_value' => 1000,
            'thunder_x' => false,
        ]);

        $this->assertSame(10.0 + (1000 * 0.25 / 100), $result['thunder_commission']);
    }

    #[Test]
    public function it_interprets_string_no_as_non_member(): void
    {
        $result = $this->service->calculate([
            'input_method' => 'trade_value',
            'trade_value' => 1000,
            'thunder_x' => 'no',
        ]);

        $this->assertSame(10.0 + (1000 * 0.25 / 100), $result['thunder_commission']);
    }

    #[Test]
    public function it_interprets_string_yes_as_member(): void
    {
        $result = $this->service->calculate([
            'input_method' => 'trade_value',
            'trade_value' => 1000,
            'thunder_x' => 'yes',
        ]);

        $this->assertSame(0.0, $result['thunder_commission']);
    }

    #[Test]
    public function it_sums_all_exchange_fees(): void
    {
        $result = $this->service->calculate([
            'input_method' => 'trade_value',
            'trade_value' => 1000,
            'thunder_x' => false,
        ]);

        $this->assertSame(1000 * ((0.15 + 0.1 + 0.05 + 0.02) / 100), $result['exchange_fees']);
    }

    #[Test]
    public function it_calculates_total_fees_and_net_cost(): void
    {
        $result = $this->service->calculate([
            'input_method' => 'trade_value',
            'trade_value' => 1000,
            'thunder_x' => false,
        ]);

        $expectedThunder = 10.0 + (1000 * 0.25 / 100);
        $expectedExchange = 1000 * ((0.15 + 0.1 + 0.05 + 0.02) / 100);

        $this->assertSame($expectedThunder + $expectedExchange, $result['total_fees']);
        $this->assertSame(1000 + $expectedThunder + $expectedExchange, $result['net_cost']);
    }

    #[Test]
    public function it_calculates_break_even_share_price_when_quantity_is_available(): void
    {
        $result = $this->service->calculate([
            'input_method' => 'quantity',
            'quantity' => 100,
            'share_price' => 50,
            'thunder_x' => false,
        ]);

        $expectedNetCost = $result['net_cost'];

        $this->assertSame($expectedNetCost / 100, $result['break_even_share_price']);
    }

    #[Test]
    public function it_returns_null_break_even_price_without_quantity(): void
    {
        $result = $this->service->calculate([
            'input_method' => 'trade_value',
            'trade_value' => 1000,
            'thunder_x' => false,
        ]);

        $this->assertNull($result['break_even_share_price']);
    }

    #[Test]
    public function it_returns_zero_break_even_price_for_zero_quantity(): void
    {
        $result = $this->service->calculate([
            'input_method' => 'quantity',
            'quantity' => 0,
            'share_price' => 50,
            'thunder_x' => false,
        ]);

        $this->assertNull($result['break_even_share_price']);
    }
}
