<?php

namespace Tests\Unit;

use App\Models\TradeTrack;
use App\Services\TradeTrackWalletService;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class TradeTrackWalletServiceTest extends TestCase
{
    private TradeTrackWalletService $service;

    protected function setUp(): void
    {
        parent::setUp();

        $this->service = new TradeTrackWalletService();
    }

    #[Test]
    public function it_keeps_buy_cash_impact_negative_when_amount_is_already_negative(): void
    {
        $tradeTrack = new TradeTrack([
            'amount' => -125.5,
            'type' => 'buy',
        ]);

        $this->assertSame(-12550, $this->service->cashImpactInCents($tradeTrack));
    }

    #[Test]
    public function it_generates_positive_cash_impact_for_sell_and_profit(): void
    {
        $this->assertSame(25000, $this->service->cashImpactInCents(new TradeTrack([
            'amount' => 250.0,
            'type' => 'sell',
        ])));

        $this->assertSame(15000, $this->service->cashImpactInCents(new TradeTrack([
            'amount' => 150.0,
            'type' => 'profit',
        ])));
    }
}
