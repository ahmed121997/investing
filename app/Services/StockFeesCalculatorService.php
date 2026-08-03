<?php

namespace App\Services;

use App\Models\StockFeeSetting;

class StockFeesCalculatorService
{
    public const INPUT_METHOD_TRADE_VALUE = 'trade_value';

    public const INPUT_METHOD_QUANTITY = 'quantity';

    public const THUNDER_X_NO = 'no';

    public const THUNDER_X_YES = 'yes';

    public const SETTLEMENT_T0 = 't0';

    public const SETTLEMENT_T1_T2 = 't1_t2';

    protected StockFeeSetting $settings;

    public function __construct(?StockFeeSetting $settings = null)
    {
        $this->settings = $settings ?? StockFeeSetting::current();
    }

    public static function make(?StockFeeSetting $settings = null): static
    {
        return new static($settings ?? StockFeeSetting::current());
    }

    /**
     * Resolve the complete set of fees for a single calculator run.
     *
     * @param  array<string, mixed>  $input
     */
    public function calculate(array $input): StockFeesCalculationResult
    {
        $tradeValue = $this->resolveTradeValue($input);

        $thunderCommission = $this->resolveThunderCommission($input, $tradeValue);

        $exchangeFeeAmount = $this->percentageAmount($tradeValue, $this->settings->exchange_fee_percentage);
        $riskFundFeeAmount = $this->percentageAmount($tradeValue, $this->settings->risk_fund_fee_percentage);
        $misrClearingFeeAmount = $this->percentageAmount($tradeValue, $this->settings->misr_clearing_fee_percentage);
        $fraFeeAmount = $this->calculateFraFeeAmount($tradeValue);

        $totalExchangeFees = $exchangeFeeAmount + $riskFundFeeAmount + $misrClearingFeeAmount + $fraFeeAmount;

        $settlementType = $this->resolveSettlementType($input);
        $taxRate = $this->resolveTaxRate($settlementType);
        $taxAmount = $this->percentageAmount($tradeValue, $taxRate);

        $totalFees = $thunderCommission + $totalExchangeFees + $taxAmount;

        $netCost = $tradeValue + $totalFees;

        $quantity = $this->resolveQuantity($input);

        return new StockFeesCalculationResult(
            tradeValue: $tradeValue,
            thunderCommission: $thunderCommission,
            exchangeFeeAmount: $exchangeFeeAmount,
            riskFundFeeAmount: $riskFundFeeAmount,
            misrClearingFeeAmount: $misrClearingFeeAmount,
            fraFeeAmount: $fraFeeAmount,
            totalExchangeFees: $totalExchangeFees,
            taxAmount: $taxAmount,
            totalFees: $totalFees,
            netCost: $netCost,
            breakEvenSharePrice: $this->calculateBreakEvenSharePrice($netCost, $quantity),
            thunderFixedFee: $this->settings->thunder_fixed_fee,
            thunderPercentage: $this->settings->thunder_percentage,
            exchangeFeePercentage: $this->settings->exchange_fee_percentage,
            riskFundFeePercentage: $this->settings->risk_fund_fee_percentage,
            misrClearingFeePercentage: $this->settings->misr_clearing_fee_percentage,
            fraFeePercentage: $this->settings->fra_fee_percentage,
            fraFeeMinimum: $this->settings->fra_fee_minimum,
            taxRate: $taxRate,
            settlementType: $settlementType,
            inputMethod: $this->inputMethod($input),
        );
    }

    /**
     * Thunder commission for non-members: fixed fee + (trade value × percentage).
     */
    public function calculateThunderCommission(float $tradeValue): float
    {
        return (float) $this->settings->thunder_fixed_fee
            + ($tradeValue * ((float) $this->settings->thunder_percentage / 100));
    }

    /**
     * FRA fee: percentage of the trade value, floored at the configured minimum.
     */
    public function calculateFraFeeAmount(float $tradeValue): float
    {
        if ($tradeValue <= 0) {
            return 0.0;
        }

        $amount = $this->percentageAmount($tradeValue, $this->settings->fra_fee_percentage);

        return max($amount, (float) $this->settings->fra_fee_minimum);
    }

    /**
     * Break-even price per share: total net cost ÷ quantity.
     */
    public function calculateBreakEvenSharePrice(float $netCost, ?float $quantity): ?float
    {
        if (blank($quantity) || $quantity <= 0) {
            return null;
        }

        return $netCost / $quantity;
    }

    /**
     * @param  array<string, mixed>  $input
     */
    protected function resolveTradeValue(array $input): float
    {
        if ($this->inputMethod($input) === self::INPUT_METHOD_QUANTITY) {
            $quantity = (float) ($input['quantity'] ?? 0);
            $sharePrice = (float) ($input['share_price'] ?? 0);

            return $quantity * $sharePrice;
        }

        return (float) ($input['trade_value'] ?? 0);
    }

    /**
     * @param  array<string, mixed>  $input
     */
    protected function resolveThunderCommission(array $input, float $tradeValue): float
    {
        if ($this->isThunderXMember($input)) {
            return 0.0;
        }

        return $this->calculateThunderCommission($tradeValue);
    }

    /**
     * @param  array<string, mixed>  $input
     */
    protected function resolveSettlementType(array $input): string
    {
        $settlementType = (string) ($input['settlement_type'] ?? self::SETTLEMENT_T0);

        return in_array($settlementType, [self::SETTLEMENT_T0, self::SETTLEMENT_T1_T2], true)
            ? $settlementType
            : self::SETTLEMENT_T0;
    }

    protected function resolveTaxRate(string $settlementType): float
    {
        return $settlementType === self::SETTLEMENT_T1_T2
            ? (float) $this->settings->tax_t1_t2_percentage
            : (float) $this->settings->tax_t0_percentage;
    }

    /**
     * @param  array<string, mixed>  $input
     */
    protected function resolveQuantity(array $input): ?float
    {
        if ($this->inputMethod($input) !== self::INPUT_METHOD_QUANTITY) {
            return null;
        }

        $quantity = (float) ($input['quantity'] ?? 0);

        return $quantity > 0 ? $quantity : null;
    }

    /**
     * @param  array<string, mixed>  $input
     */
    protected function inputMethod(array $input): string
    {
        return (string) ($input['input_method'] ?? self::INPUT_METHOD_TRADE_VALUE);
    }

    /**
     * @param  array<string, mixed>  $input
     */
    protected function isThunderXMember(array $input): bool
    {
        return in_array($input['thunder_x'] ?? false, [true, self::THUNDER_X_YES, '1', 1], true);
    }

    protected function percentageAmount(float $base, float $percentage): float
    {
        return $base * ($percentage / 100);
    }
}
