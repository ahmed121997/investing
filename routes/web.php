<?php

use Illuminate\Support\Facades\Route;

Route::get('/admin/language/{locale}', function (string $locale) {
    abort_unless(in_array($locale, config('filament-translation-manager.locales', []), true), 404);

    session(['locale' => $locale]);

    return redirect()->back();
})->name('filament.language.switch');

Route::get('/', function () {
    return redirect('admin');
});
