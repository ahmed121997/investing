<?php

namespace Tests\Feature;

use App\Filament\Pages\StockFeesCalculator;
use App\Filament\Pages\StockFeesSettings;
use App\Models\StockFeeSetting;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class StockFeesPagesTest extends TestCase
{
    use RefreshDatabase;

    private User $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
    }

    public function test_calculator_page_can_be_rendered(): void
    {
        $this->actingAs($this->user);

        Livewire::test(StockFeesCalculator::class)
            ->assertSuccessful();
    }

    public function test_calculator_page_recalculates_live(): void
    {
        $this->actingAs($this->user);

        Livewire::test(StockFeesCalculator::class)
            ->set('data.input_method', 'quantity')
            ->set('data.quantity', 100)
            ->set('data.share_price', 50)
            ->set('data.thunder_x', 'yes')
            ->set('data.settlement_type', 't1_t2')
            ->assertSet('data.quantity', 100)
            ->assertSet('data.settlement_type', 't1_t2')
            ->assertSuccessful();
    }

    public function test_calculator_page_mounts_with_defaults(): void
    {
        $this->actingAs($this->user);

        Livewire::test(StockFeesCalculator::class)
            ->assertSet('data.input_method', 'trade_value')
            ->assertSet('data.thunder_x', 'no')
            ->assertSet('data.settlement_type', 't0');
    }

    public function test_settings_page_can_be_rendered_and_saved(): void
    {
        $this->actingAs($this->user);

        Livewire::test(StockFeesSettings::class)
            ->assertSuccessful()
            ->set('data.thunder_percentage', '0.5')
            ->set('data.fra_fee_minimum', '2')
            ->set('data.tax_t0_percentage', '0.03')
            ->set('data.tax_t1_t2_percentage', '0.06')
            ->call('save')
            ->assertHasNoErrors();

        $this->assertDatabaseHas('stock_fee_settings', [
            'thunder_percentage' => 0.5,
            'fra_fee_minimum' => 2,
            'tax_t0_percentage' => 0.03,
            'tax_t1_t2_percentage' => 0.06,
        ]);
    }

    public function test_settings_page_seeds_default_values(): void
    {
        $this->actingAs($this->user);

        Livewire::test(StockFeesSettings::class)
            ->assertSet('data.thunder_fixed_fee', 2)
            ->assertSet('data.thunder_percentage', 0.1)
            ->assertSet('data.fra_fee_minimum', 1)
            ->assertSet('data.tax_t0_percentage', 0.025)
            ->assertSet('data.tax_t1_t2_percentage', 0.05);
    }

    public function test_settings_defaults_are_applied_for_fresh_install(): void
    {
        $this->actingAs($this->user);

        $settings = StockFeeSetting::current();

        $this->assertSame(2.0, $settings->thunder_fixed_fee);
        $this->assertSame(0.1, $settings->thunder_percentage);
        $this->assertSame(1.0, $settings->fra_fee_minimum);
        $this->assertSame(0.025, $settings->tax_t0_percentage);
        $this->assertSame(0.05, $settings->tax_t1_t2_percentage);
    }
}
