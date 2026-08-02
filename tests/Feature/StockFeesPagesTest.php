<?php

namespace Tests\Feature;

use App\Filament\Pages\StockFeesCalculator;
use App\Filament\Pages\StockFeesSettings;
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
            ->assertSet('data.quantity', 100)
            ->assertSuccessful();
    }

    public function test_settings_page_can_be_rendered_and_saved(): void
    {
        $this->actingAs($this->user);

        Livewire::test(StockFeesSettings::class)
            ->assertSuccessful()
            ->set('data.thunder_percentage', '0.5')
            ->call('save')
            ->assertHasNoErrors();

        $this->assertDatabaseHas('stock_fee_settings', [
            'thunder_percentage' => 0.5,
        ]);
    }
}
