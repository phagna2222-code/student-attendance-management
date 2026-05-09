<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class SetLocale
{
    private const SESSION_KEY = 'app.locale';
    private const SUPPORTED = ['en', 'km'];

    public function handle(Request $request, Closure $next)
    {
        $locale = $request->session()->get(self::SESSION_KEY)
            ?? $request->cookie('app_locale')
            ?? config('app.locale');

        if (! in_array($locale, self::SUPPORTED, true)) {
            $locale = 'en';
        }

        App::setLocale($locale);
        return $next($request);
    }
}
