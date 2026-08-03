<?php

namespace App\Services;

/**
 * Immutable value object holding the output of a stock fees calculation.
 *
 * @phpstan-type StockFeesCalculationResultArray array{
 *     trade_value: float,
 *     thunder_commission: float,
 *     exchange_fee_amount: float,
 *     risk_fund_fee_amount: float,
 *     misr_clearing_fee_amount: float,
 *     fra_fee_amount: float,
 *     total_exchange_fees: float,
 *     tax_amount: float,
 *     total_fees: float,
 *     net_cost: float,
 *     break_even_share_price: float|null,
 *     thunder_percentage: float,
 *     exchange_fee_percentage: float,
 *     risk_fund_fee_percentage: float,
 *     misr_clearing_fee_percentage: float,
 *     fra_fee_percentage: float,
 *     fra_fee_minimum: float,
 *     tax_rate: float,
 *     settlement_type: string,
 * }
 */
final readonly class StockFeesCalculationResult
{
    public function __construct(
        public float $tradeValue,
        public float $thunderCommission,
        public float $exchangeFeeAmount,
        public float $riskFundFeeAmount,
        public float $misrClearingFeeAmount,
        public float $fraFeeAmount,
        public float $totalExchangeFees,
        public float $taxAmount,
        public float $totalFees,
        public float $netCost,
        public ?float $breakEvenSharePrice,
        public float $thunderFixedFee,
        public float $thunderPercentage,
        public float $exchangeFeePercentage,
        public float $riskFundFeePercentage,
        public float $misrClearingFeePercentage,
        public float $fraFeePercentage,
        public float $fraFeeMinimum,
        public float $taxRate,
        public string $settlementType,
        public string $inputMethod,
    ) {}

    /**
     * @return StockFeesCalculationResultArray
     */
    public function toArray(): array
    {
        return [
            'trade_value' => $this->tradeValue,
            'thunder_commission' => $this->thunderCommission,
            'exchange_fee_amount' => $this->exchangeFeeAmount,
            'risk_fund_fee_amount' => $this->riskFundFeeAmount,
            'misr_clearing_fee_amount' => $this->misrClearingFeeAmount,
            'fra_fee_amount' => $this->fraFeeAmount,
            'total_exchange_fees' => $this->totalExchangeFees,
            'tax_amount' => $this->taxAmount,
            'total_fees' => $this->totalFees,
            'net_cost' => $this->netCost,
            'break_even_share_price' => $this->breakEvenSharePrice,
            'thunder_percentage' => $this->thunderPercentage,
            'thunder_fixed_fee' => $this->thunderFixedFee,
            'exchange_fee_percentage' => $this->exchangeFeePercentage,
            'risk_fund_fee_percentage' => $this->riskFundFeePercentage,
            'misr_clearing_fee_percentage' => $this->misrClearingFeePercentage,
            'fra_fee_percentage' => $this->fraFeePercentage,
            'fra_fee_minimum' => $this->fraFeeMinimum,
            'tax_rate' => $this->taxRate,
            'settlement_type' => $this->settlementType,
            'input_method' => $this->inputMethod,
        ];
    }
}
