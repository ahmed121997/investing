<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    public function handle(Request $request, Closure $next): Response
    {
        $locale = $request->session()->get('locale', config('app.locale'));
        $availableLocales = config('filament-translation-manager.locales', []);

        if (in_array($locale, $availableLocales, true)) {
            App::setLocale($locale);
        }

        return $next($request);
    }
}
