<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Http;

class SetLocaleFromRequest
{
    public function handle(Request $request, Closure $next)
    {
        $availableLocales = config('app.available_locales', ['en']);
        $fallbackLocale = config('app.fallback_locale', 'en');

        $userSelectedLocale = $this->resolveUserSelection($request, $availableLocales);
        $locale = $userSelectedLocale ?? $this->detectLocaleFromIp($request->ip(), $availableLocales, $fallbackLocale);

        App::setLocale($locale);

        return $next($request);
    }

    private function resolveUserSelection(Request $request, array $availableLocales): ?string
    {
        $queryLocale = $request->query('lang');
        if ($queryLocale && in_array($queryLocale, $availableLocales)) {
            Cookie::queue('locale', $queryLocale, 60 * 24 * 30);
            session(['locale' => $queryLocale]);
            return $queryLocale;
        }

        $sessionLocale = session('locale');
        if ($sessionLocale && in_array($sessionLocale, $availableLocales)) {
            return $sessionLocale;
        }

        $cookieLocale = $request->cookie('locale');
        if ($cookieLocale && in_array($cookieLocale, $availableLocales)) {
            session(['locale' => $cookieLocale]);
            return $cookieLocale;
        }

        return null;
    }

    private function detectLocaleFromIp(?string $ip, array $availableLocales, string $fallbackLocale): string
    {
        if (!$ip || $ip === '127.0.0.1' || $ip === '::1') {
            return $fallbackLocale;
        }

        try {
            $response = Http::timeout(2)->get("https://ipapi.co/{$ip}/json/");

            if ($response->successful()) {
                $countryCode = strtolower((string) $response->json('country_code', ''));
                $countryMap = config('app.locale_country_map', []);

                foreach ($countryMap as $locale => $countries) {
                    if (in_array($countryCode, $countries, true) && in_array($locale, $availableLocales, true)) {
                        session(['locale' => $locale]);
                        Cookie::queue('locale', $locale, 60 * 24 * 30);
                        return $locale;
                    }
                }
            }
        } catch (\Throwable $exception) {
            // Fail silently and fall back to default locale
        }

        return $fallbackLocale;
    }
}
