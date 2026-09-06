<?php

namespace App\Filament\Concerns;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

trait HidesFromAdminNavigation
{
    public static function shouldRegisterNavigation(): bool
    {
        return ! User::query()->whereKey(Auth::id())->where('role', 'admin')->exists();
    }
}
