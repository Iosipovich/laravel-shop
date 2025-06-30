<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SetLocale
{
    public function handle(Request $request, Closure $next)
    {
        $locale = session('locale', 'ru'); // По умолчанию русский
        if (in_array($locale, ['ru', 'ro'])) {
            app()->setLocale($locale);
        }
        return $next($request);
    }
}