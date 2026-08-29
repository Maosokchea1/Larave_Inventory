<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    /**
     * List of supported locales.
     */
    protected array $supportedLocales = ['en', 'km'];

    public function handle(Request $request, Closure $next): Response
    {
        // 1. Prioritize language setting: Query Param (?lang=) -> Session -> Cookie -> App Default
        $locale = $request->query('lang') 
            ?? $request->query('locale') 
            ?? ($request->hasSession() ? session('locale') : null)
            ?? $request->cookie('locale') 
            ?? config('app.locale');

        // 2. Fallback to default if language is not supported
        if (! in_array($locale, $this->supportedLocales, true)) {
            $locale = config('app.fallback_locale', 'en');
        }

        // 3. Set application locale
        App::setLocale($locale);

        // 4. Save to session if session store is active
        if ($request->hasSession()) {
            $request->session()->put('locale', $locale);
        }

        // 5. Queue cookie for persistence across sessions (valid for 1 year)
        cookie()->queue('locale', $locale, 60 * 24 * 365);

        return $next($request);
    }
}