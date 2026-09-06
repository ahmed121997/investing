<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Http\Controllers\FinancialReportImageController;

Route::middleware('auth')->get('/admin/stop-impersonating', function () {
    $admin = User::find(session('impersonating_admin_id'));

    abort_unless($admin?->isAdmin() && $admin->is_active, 403);

    Auth::guard('web')->login($admin);
    session()->put('password_hash_web', $admin->getAuthPassword());
    session()->forget('impersonating_admin_id');

    return redirect('/admin');
})->name('admin.stop-impersonating');

Route::get('/admin/language/{locale}', function (string $locale) {
    abort_unless(in_array($locale, config('filament-translation-manager.locales', []), true), 404);

    session(['locale' => $locale]);

    return redirect()->back();
})->name('filament.language.switch');

Route::get('/', function () {
    return redirect('admin');
});

Route::get('/financial-reports/{financialReport}/image', FinancialReportImageController::class)
    ->middleware('auth')
    ->name('financial-reports.image');
