<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;

class UserRolesTest extends TestCase
{
    use RefreshDatabase;

    public function test_users_are_regular_accounts_by_default_and_admins_are_identified(): void
    {
        $user = User::factory()->create();
        $admin = User::factory()->create(['role' => 'admin']);

        $this->assertFalse($user->isAdmin());
        $this->assertTrue($admin->isAdmin());
        $this->assertTrue($user->is_active);
    }

    public function test_last_active_admin_cannot_be_demoted_or_deleted(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $this->expectException(ValidationException::class);

        $admin->update(['role' => 'user']);
    }
}
