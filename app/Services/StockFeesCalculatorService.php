<?php

namespace App\Services;

use App\Models\StockFeeSetting;

class StockFeesCalculatorService
{
    public function __construct(
        protected StockFeeSetting $settings,
    ) {}

    public static function make(?StockFeeSetting $settings = null): static
    {
        return new static($settings ?? StockFeeSetting::current());
    }

    /**
     * @param  array{
     *     input_method: string,
     *     trade_value?: float|null,
     *     quantity?: float|null,
     *     share_price?: float|null,
     *     thunder_x?: bool,
     * }  $input
     * @return array{
     *     trade_value: float,
     *     thunder_commission: float,
     *     exchange_fees: float,
     *     total_fees: float,
     *     net_cost: float,
     *     break_even_share_price: float|null,
     * }
     */
    public function calculate(array $input): array
    {
        $inputMethod = $input['input_method'] ?? 'trade_value';

        $tradeValue = match ($inputMethod) {
            'quantity' => $this->tradeValueFromQuantity(
                quantity: $input['quantity'] ?? 0,
                sharePrice: $input['share_price'] ?? 0,
            ),
            default => (float) ($input['trade_value'] ?? 0),
        };

        $isThunderX = match (($input['thunder_x'] ?? false)) {
            true, 'yes', '1', 1 => true,
            default => false,
        };

        $thunderCommission = $isThunderX
            ? 0.0
            : $this->calculateThunderCommission($tradeValue);

        $exchangeFees = $this->calculateExchangeFees($tradeValue);

        $totalFees = $thunderCommission + $exchangeFees;

        $netCost = $tradeValue + $totalFees;

        $quantity = $inputMethod === 'quantity' ? (float) ($input['quantity'] ?? 0) : null;

        return [
            'trade_value' => $tradeValue,
            'thunder_commission' => $thunderCommission,
            'exchange_fees' => $exchangeFees,
            'total_fees' => $totalFees,
            'net_cost' => $netCost,
            'break_even_share_price' => $this->calculateBreakEvenSharePrice($netCost, $quantity),
        ];
    }

    public function calculateThunderCommission(float $tradeValue): float
    {
        return (float) $this->settings->thunder_fixed_fee
            + ($tradeValue * (float) $this->settings->thunder_percentage / 100);
    }

    public function calculateExchangeFees(float $tradeValue): float
    {
        $totalPercentage = collect([
            $this->settings->exchange_fee_percentage,
            $this->settings->egx_fee_percentage,
            $this->settings->misr_clearing_fee_percentage,
            $this->settings->fra_fee_percentage,
        ])->sum();

        return $tradeValue * ($totalPercentage / 100);
    }

    public function calculateBreakEvenSharePrice(float $netCost, ?float $quantity): ?float
    {
        if (blank($quantity) || $quantity <= 0) {
            return null;
        }

        return $netCost / $quantity;
    }

    private function tradeValueFromQuantity(float $quantity, float $sharePrice): float
    {
        return $quantity * $sharePrice;
    }
}
