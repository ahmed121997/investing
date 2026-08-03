<?php

namespace Tests\Unit;

use App\Models\StockFeeSetting;
use App\Services\StockFeesCalculationResult;
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
            'risk_fund_fee_percentage' => 0.1,
            'misr_clearing_fee_percentage' => 0.05,
            'fra_fee_percentage' => 0.02,
            'fra_fee_minimum' => 5,
            'tax_t0_percentage' => 0.025,
            'tax_t1_t2_percentage' => 0.05,
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
            'settlement_type' => 't0',
        ]);

        $this->assertInstanceOf(StockFeesCalculationResult::class, $result);
        $this->assertSame(1000.0, $result->tradeValue);
    }

    #[Test]
    public function it_calculates_trade_value_from_quantity_and_price(): void
    {
        $result = $this->service->calculate([
            'input_method' => 'quantity',
            'quantity' => 100,
            'share_price' => 50,
            'thunder_x' => false,
            'settlement_type' => 't0',
        ]);

        $this->assertSame(5000.0, $result->tradeValue);
    }

    #[Test]
    public function it_waives_thunder_commission_for_thunder_x_members(): void
    {
        $result = $this->service->calculate([
            'input_method' => 'trade_value',
            'trade_value' => 1000,
            'thunder_x' => true,
            'settlement_type' => 't0',
        ]);

        $this->assertSame(0.0, $result->thunderCommission);
    }

    #[Test]
    public function it_applies_fixed_fee_and_percentage_for_non_members(): void
    {
        $result = $this->service->calculate([
            'input_method' => 'trade_value',
            'trade_value' => 1000,
            'thunder_x' => false,
            'settlement_type' => 't0',
        ]);

        $this->assertSame(10.0 + (1000 * 0.25 / 100), $result->thunderCommission);
    }

    #[Test]
    public function it_interprets_string_no_as_non_member(): void
    {
        $result = $this->service->calculate([
            'input_method' => 'trade_value',
            'trade_value' => 1000,
            'thunder_x' => 'no',
            'settlement_type' => 't0',
        ]);

        $this->assertSame(10.0 + (1000 * 0.25 / 100), $result->thunderCommission);
    }

    #[Test]
    public function it_interprets_string_yes_as_member(): void
    {
        $result = $this->service->calculate([
            'input_method' => 'trade_value',
            'trade_value' => 1000,
            'thunder_x' => 'yes',
            'settlement_type' => 't0',
        ]);

        $this->assertSame(0.0, $result->thunderCommission);
    }

    #[Test]
    public function it_breaks_down_each_exchange_fee(): void
    {
        $result = $this->service->calculate([
            'input_method' => 'trade_value',
            'trade_value' => 1000,
            'thunder_x' => false,
            'settlement_type' => 't0',
        ]);

        $this->assertSame(1000 * (0.15 / 100), $result->exchangeFeeAmount);
        $this->assertSame(1000 * (0.1 / 100), $result->riskFundFeeAmount);
        $this->assertSame(1000 * (0.05 / 100), $result->misrClearingFeeAmount);
        $this->assertSame(max(1000 * (0.02 / 100), 5.0), $result->fraFeeAmount);

        $expectedTotal = (1000 * (0.15 / 100)) + (1000 * (0.1 / 100)) + (1000 * (0.05 / 100)) + $result->fraFeeAmount;
        $this->assertSame($expectedTotal, $result->totalExchangeFees);
    }

    #[Test]
    public function it_returns_the_whole_minimum_when_fra_percentage_fee_is_below_it(): void
    {
        $result = $this->service->calculate([
            'input_method' => 'trade_value',
            'trade_value' => 1000,
            'thunder_x' => false,
            'settlement_type' => 't0',
        ]);

        $this->assertSame(5.0, $result->fraFeeAmount);
        $this->assertSame(5.0, $result->fraFeeMinimum);
    }

    #[Test]
    public function it_uses_percentage_amount_when_above_the_fra_minimum(): void
    {
        $result = $this->service->calculate([
            'input_method' => 'trade_value',
            'trade_value' => 100000,
            'thunder_x' => false,
            'settlement_type' => 't0',
        ]);

        $this->assertSame(100000 * (0.02 / 100), $result->fraFeeAmount);
    }

    #[Test]
    public function it_returns_zero_fra_fee_without_a_trade_value(): void
    {
        $result = $this->service->calculate([]);

        $this->assertSame(0.0, $result->fraFeeAmount);
    }

    #[Test]
    public function it_applies_t0_tax_rate(): void
    {
        $result = $this->service->calculate([
            'input_method' => 'trade_value',
            'trade_value' => 1000,
            'thunder_x' => false,
            'settlement_type' => 't0',
        ]);

        $this->assertSame(1000 * (0.025 / 100), $result->taxAmount);
        $this->assertSame(0.025, $result->taxRate);
    }

    #[Test]
    public function it_applies_t1_t2_tax_rate(): void
    {
        $result = $this->service->calculate([
            'input_method' => 'trade_value',
            'trade_value' => 1000,
            'thunder_x' => false,
            'settlement_type' => 't1_t2',
        ]);

        $this->assertSame(1000 * (0.05 / 100), $result->taxAmount);
        $this->assertSame(0.05, $result->taxRate);
        $this->assertSame('t1_t2', $result->settlementType);
    }

    #[Test]
    public function it_defaults_to_t0_tax_when_settlement_is_missing(): void
    {
        $result = $this->service->calculate([
            'input_method' => 'trade_value',
            'trade_value' => 1000,
            'thunder_x' => false,
        ]);

        $this->assertSame(1000 * (0.025 / 100), $result->taxAmount);
    }

    #[Test]
    public function it_calculates_total_fees_and_net_cost(): void
    {
        $result = $this->service->calculate([
            'input_method' => 'trade_value',
            'trade_value' => 1000,
            'thunder_x' => false,
            'settlement_type' => 't0',
        ]);

        $expectedThunder = 10.0 + (1000 * 0.25 / 100);
        $expectedExchange = (1000 * (0.15 / 100)) + (1000 * (0.1 / 100)) + (1000 * (0.05 / 100)) + 5.0;
        $expectedTax = 1000 * (0.025 / 100);

        $this->assertSame($expectedThunder + $expectedExchange + $expectedTax, $result->totalFees);
        $this->assertSame(1000 + $expectedThunder + $expectedExchange + $expectedTax, $result->netCost);
    }

    #[Test]
    public function it_calculates_break_even_share_price_when_quantity_is_available(): void
    {
        $result = $this->service->calculate([
            'input_method' => 'quantity',
            'quantity' => 100,
            'share_price' => 50,
            'thunder_x' => false,
            'settlement_type' => 't0',
        ]);

        $this->assertSame($result->netCost / 100, $result->breakEvenSharePrice);
    }

    #[Test]
    public function it_returns_null_break_even_price_without_quantity(): void
    {
        $result = $this->service->calculate([
            'input_method' => 'trade_value',
            'trade_value' => 1000,
            'thunder_x' => false,
            'settlement_type' => 't0',
        ]);

        $this->assertNull($result->breakEvenSharePrice);
    }

    #[Test]
    public function it_returns_null_break_even_price_for_zero_quantity(): void
    {
        $result = $this->service->calculate([
            'input_method' => 'quantity',
            'quantity' => 0,
            'share_price' => 50,
            'thunder_x' => false,
            'settlement_type' => 't0',
        ]);

        $this->assertNull($result->breakEvenSharePrice);
    }

    #[Test]
    public function it_returns_defaults_when_input_is_empty(): void
    {
        $result = $this->service->calculate([]);

        $this->assertSame(0.0, $result->tradeValue);
        $this->assertSame(0.0, $result->exchangeFeeAmount);
        $this->assertSame(0.0, $result->taxAmount);
        $this->assertSame(10.0, $result->thunderCommission);
        $this->assertSame(10.0, $result->totalFees);
        $this->assertSame(10.0, $result->netCost);
        $this->assertNull($result->breakEvenSharePrice);
    }
}
