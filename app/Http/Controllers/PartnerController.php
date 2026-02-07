<?php

namespace App\Http\Controllers;

use App\Models\AuthorizedPartner;
use Illuminate\Http\Request;

class PartnerController extends Controller
{
    /**
     * Display the public partner directory.
     */
    public function directory(Request $request)
    {
        $query = AuthorizedPartner::with('user')
            ->active();

        if ($request->filled('country')) {
            $country = $request->country;
            $query->whereJsonContains('authorized_countries', $country);
        }

        $partners = $query->orderBy('business_name')->get();

        return view('partners.directory', compact('partners'));
    }

    /**
     * Display the public verification page for a partner.
     */
    public function verify(string $reference)
    {
        $partner = AuthorizedPartner::with('user')
            ->where('reference_number', $reference)
            ->first();

        return view('partners.verify', compact('partner', 'reference'));
    }
}
