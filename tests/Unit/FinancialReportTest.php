<?php

namespace Tests\Unit;

use App\Models\FinancialReport;
use Tests\TestCase;

class FinancialReportTest extends TestCase
{
    public function test_it_calculates_coverage_and_growth(): void
    {
        $report = new FinancialReport([
            'revenue_b' => 100,
            'revenue_a' => 125,
        ]);

        $this->assertSame(125.0, $report->coverage('revenue'));
        $this->assertSame(25.0, $report->growth('revenue'));
    }

    public function test_growth_is_unavailable_when_base_value_is_zero(): void
    {
        $report = new FinancialReport([
            'revenue_b' => 0,
            'revenue_a' => 125,
        ]);

        $this->assertNull($report->growth('revenue'));
    }
}
