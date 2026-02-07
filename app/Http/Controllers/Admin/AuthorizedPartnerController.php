<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AuthorizedPartner;
use App\Models\User;
use App\Mail\PartnerApproved;
use App\Services\PartnerCertificateService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class AuthorizedPartnerController extends Controller
{
    /**
     * Display a listing of authorized partners.
     */
    public function index(Request $request)
    {
        $query = AuthorizedPartner::with('user');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('business_name', 'like', "%{$search}%")
                  ->orWhere('reference_number', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('tax_id', 'like', "%{$search}%")
                  ->orWhereHas('user', function ($uq) use ($search) {
                      $uq->where('name', 'like', "%{$search}%");
                  });
            });
        }

        $stats = [
            'total' => AuthorizedPartner::count(),
            'active' => AuthorizedPartner::where('status', 'active')->where('expires_at', '>', now())->count(),
            'pending_review' => AuthorizedPartner::where('status', 'pending_review')->count(),
            'expired' => AuthorizedPartner::where('status', 'active')->where('expires_at', '<=', now())->count(),
            'suspended' => AuthorizedPartner::where('status', 'suspended')->count(),
        ];

        $partners = $query->orderByDesc('created_at')->paginate(15);

        return view('admin.authorized-partners.index', compact('partners', 'stats'));
    }

    /**
     * Show the form to create a new partner.
     */
    public function create()
    {
        $serviceUsers = User::where('user_type', User::TYPE_SERVICE_USER)
            ->whereDoesntHave('authorizedPartner')
            ->where('is_active', true)
            ->orderBy('name')
            ->get();

        return view('admin.authorized-partners.create', compact('serviceUsers'));
    }

    /**
     * Store a newly created partner.
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id|unique:authorized_partners,user_id',
        ], [
            'user_id.unique' => 'This user already has a partner record.',
        ]);

        $user = User::findOrFail($request->user_id);

        if ($user->user_type !== User::TYPE_SERVICE_USER) {
            return back()->with('error', 'Only service users can be designated as partners.');
        }

        $partner = AuthorizedPartner::create([
            'user_id' => $user->id,
            'reference_number' => AuthorizedPartner::generateReferenceNumber(),
            'status' => 'pending_profile',
            'email' => $user->email,
        ]);

        return redirect()
            ->route('admin.authorized-partners.show', $partner)
            ->with('success', 'Partner record created. User can now complete their business profile.');
    }

    /**
     * Display the specified partner.
     */
    public function show(AuthorizedPartner $partner)
    {
        $partner->load('user');

        return view('admin.authorized-partners.show', compact('partner'));
    }

    /**
     * Approve the partner.
     */
    public function approve(Request $request, AuthorizedPartner $partner)
    {
        $request->validate([
            'authorized_countries' => 'required|array|min:1',
            'authorized_countries.*' => 'in:greece,portugal,uk',
            'admin_notes' => 'nullable|string|max:5000',
        ]);

        $partner->status = 'active';
        $partner->approved_at = now();
        $partner->expires_at = now()->addYear();
        $partner->authorized_countries = $request->authorized_countries;

        if ($request->filled('admin_notes')) {
            $timestamp = now()->format('Y-m-d H:i');
            $adminName = Auth::user()->name;
            $newNote = "[{$adminName} {$timestamp}]: Approved. {$request->admin_notes}";
            $partner->admin_notes = $partner->admin_notes
                ? $partner->admin_notes . "\n\n" . $newNote
                : $newNote;
        }

        $partner->save();

        // Generate PDF certificate
        $certificateService = new PartnerCertificateService();
        $certificateService->generate($partner);

        // Send approval email with certificate
        if ($partner->email) {
            Mail::to($partner->email)->send(new PartnerApproved($partner));
        }

        return redirect()
            ->route('admin.authorized-partners.show', $partner)
            ->with('success', 'Partner approved successfully. Certificate generated and email sent.');
    }

    /**
     * Suspend the partner.
     */
    public function suspend(Request $request, AuthorizedPartner $partner)
    {
        $request->validate([
            'admin_notes' => 'nullable|string|max:5000',
        ]);

        $partner->status = 'suspended';

        if ($request->filled('admin_notes')) {
            $timestamp = now()->format('Y-m-d H:i');
            $adminName = Auth::user()->name;
            $newNote = "[{$adminName} {$timestamp}]: Suspended. {$request->admin_notes}";
            $partner->admin_notes = $partner->admin_notes
                ? $partner->admin_notes . "\n\n" . $newNote
                : $newNote;
        }

        $partner->save();

        return redirect()
            ->route('admin.authorized-partners.show', $partner)
            ->with('success', 'Partner suspended.');
    }

    /**
     * Revoke the partner.
     */
    public function revoke(Request $request, AuthorizedPartner $partner)
    {
        $request->validate([
            'admin_notes' => 'nullable|string|max:5000',
        ]);

        $partner->status = 'revoked';

        if ($request->filled('admin_notes')) {
            $timestamp = now()->format('Y-m-d H:i');
            $adminName = Auth::user()->name;
            $newNote = "[{$adminName} {$timestamp}]: Revoked. {$request->admin_notes}";
            $partner->admin_notes = $partner->admin_notes
                ? $partner->admin_notes . "\n\n" . $newNote
                : $newNote;
        }

        $partner->save();

        return redirect()
            ->route('admin.authorized-partners.show', $partner)
            ->with('success', 'Partner revoked.');
    }

    /**
     * Renew the partner for another year.
     */
    public function renew(AuthorizedPartner $partner)
    {
        $partner->expires_at = now()->addYear();
        $partner->status = 'active';
        $partner->save();

        // Regenerate certificate with new dates
        $certificateService = new PartnerCertificateService();
        $certificateService->generate($partner);

        return redirect()
            ->route('admin.authorized-partners.show', $partner)
            ->with('success', 'Partner renewed for another year. Certificate regenerated.');
    }

    /**
     * Download the partner certificate.
     */
    public function downloadCertificate(AuthorizedPartner $partner)
    {
        if (!$partner->certificate_path || !\Illuminate\Support\Facades\Storage::disk('private')->exists($partner->certificate_path)) {
            return back()->with('error', 'Certificate not found.');
        }

        return \Illuminate\Support\Facades\Storage::disk('private')->download(
            $partner->certificate_path,
            'Partner_Certificate_' . $partner->reference_number . '.pdf'
        );
    }
}
