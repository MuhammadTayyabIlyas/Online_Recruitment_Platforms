<?php

namespace App\Http\Controllers\ServiceUser;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PartnerProfileController extends Controller
{
    /**
     * Show the partner profile form.
     */
    public function edit()
    {
        $partner = Auth::user()->authorizedPartner;

        if (!$partner) {
            abort(404, 'No partner record found for this user.');
        }

        return view('service-user.partner-profile', compact('partner'));
    }

    /**
     * Update the partner profile.
     */
    public function update(Request $request)
    {
        $partner = Auth::user()->authorizedPartner;

        if (!$partner) {
            abort(404, 'No partner record found for this user.');
        }

        if (in_array($partner->status, ['revoked'])) {
            return back()->with('error', 'Your partner status does not allow profile updates.');
        }

        $validated = $request->validate([
            'business_name' => 'required|string|max:255',
            'tax_id' => 'required|string|max:50',
            'address_line1' => 'required|string|max:255',
            'address_line2' => 'nullable|string|max:255',
            'city' => 'required|string|max:100',
            'postal_code' => 'required|string|max:20',
            'country' => 'required|string|max:100',
            'phone' => 'required|string|max:30',
            'email' => 'required|email|max:255',
        ]);

        $partner->fill($validated);

        // Move to pending_review if all required fields are filled
        if ($partner->status === 'pending_profile') {
            $partner->status = 'pending_review';
        }

        $partner->save();

        return back()->with('success', 'Partner profile updated successfully.');
    }

    /**
     * Download the partner certificate.
     */
    public function downloadCertificate()
    {
        $partner = Auth::user()->authorizedPartner;

        if (!$partner || !$partner->certificate_path || !Storage::disk('private')->exists($partner->certificate_path)) {
            return back()->with('error', 'Certificate not available.');
        }

        return Storage::disk('private')->download(
            $partner->certificate_path,
            'Partner_Certificate_' . $partner->reference_number . '.pdf'
        );
    }
}
