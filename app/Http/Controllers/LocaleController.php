<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class LocaleController extends Controller
{
    public function switch(Request $request): RedirectResponse
    {
        $availableLocales = config('app.available_locales', ['en']);
        $locale = $request->input('locale');

        if (in_array($locale, $availableLocales)) {
            session(['locale' => $locale]);
            Cookie::queue('locale', $locale, 60 * 24 * 30);
        }

        return back();
    }
}
