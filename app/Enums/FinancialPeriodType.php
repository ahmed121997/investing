<?php

namespace App\Enums;

enum FinancialPeriodType: string
{
    case YEAR = 'year';
    case HALF_YEAR = 'half_year';
    case QUARTER = 'quarter';
    case MONTH = 'month';
    case CUSTOM = 'custom';

    public function label(): string
    {
        return __('financial_reports.period_types.'.$this->value);
    }
}
