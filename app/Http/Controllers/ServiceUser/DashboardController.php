<?php

namespace App\Http\Controllers\ServiceUser;

use App\Http\Controllers\Controller;
use App\Http\Controllers\PoliceCertificateController;
use App\Http\Controllers\PortugalCertificateController;
use App\Models\PoliceCertificateApplication;
use App\Models\PortugalCertificateApplication;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // UK Police Certificate Statistics
        $ukTotalApplications = PoliceCertificateApplication::where('user_id', $user->id)->count();
        $ukPendingApplications = PoliceCertificateApplication::where('user_id', $user->id)
            ->whereIn('status', ['draft', 'submitted', 'payment_pending'])
            ->count();
        $ukCompletedApplications = PoliceCertificateApplication::where('user_id', $user->id)
            ->where('status', 'completed')
            ->count();
        $ukProcessingApplications = PoliceCertificateApplication::where('user_id', $user->id)
            ->whereIn('status', ['payment_verified', 'processing'])
            ->count();

        // Portugal Certificate Statistics
        $ptTotalApplications = PortugalCertificateApplication::where('user_id', $user->id)->count();
        $ptPendingApplications = PortugalCertificateApplication::where('user_id', $user->id)
            ->whereIn('status', ['draft', 'submitted', 'payment_pending'])
            ->count();
        $ptCompletedApplications = PortugalCertificateApplication::where('user_id', $user->id)
            ->where('status', 'completed')
            ->count();
        $ptProcessingApplications = PortugalCertificateApplication::where('user_id', $user->id)
            ->whereIn('status', ['payment_verified', 'processing'])
            ->count();

        // Combined statistics
        $totalApplications = $ukTotalApplications + $ptTotalApplications;
        $pendingApplications = $ukPendingApplications + $ptPendingApplications;
        $completedApplications = $ukCompletedApplications + $ptCompletedApplications;
        $processingApplications = $ukProcessingApplications + $ptProcessingApplications;

        // Get UK draft applications (incomplete)
        $ukDraftApplications = PoliceCertificateApplication::where('user_id', $user->id)
            ->where('status', 'draft')
            ->latest()
            ->get();

        // Add next step info to each UK draft
        $pccController = new PoliceCertificateController();
        foreach ($ukDraftApplications as $draft) {
            $draft->next_step = $pccController->getNextStep($draft);
            $draft->certificate_type = 'uk';
        }

        // Get Portugal draft applications (incomplete)
        $ptDraftApplications = PortugalCertificateApplication::where('user_id', $user->id)
            ->where('status', 'draft')
            ->latest()
            ->get();

        // Add next step info to each Portugal draft
        $ptController = new PortugalCertificateController();
        foreach ($ptDraftApplications as $draft) {
            $draft->next_step = $ptController->getNextStep($draft);
            $draft->certificate_type = 'portugal';
        }

        // Merge draft applications
        $draftApplications = $ukDraftApplications->merge($ptDraftApplications)->sortByDesc('created_at');

        // Get recent UK applications (excluding drafts)
        $ukRecentApplications = PoliceCertificateApplication::where('user_id', $user->id)
            ->where('status', '!=', 'draft')
            ->latest()
            ->take(5)
            ->get()
            ->map(function ($app) {
                $app->certificate_type = 'uk';
                $app->certificate_label = 'UK Police Certificate';
                return $app;
            });

        // Get recent Portugal applications (excluding drafts)
        $ptRecentApplications = PortugalCertificateApplication::where('user_id', $user->id)
            ->where('status', '!=', 'draft')
            ->latest()
            ->take(5)
            ->get()
            ->map(function ($app) {
                $app->certificate_type = 'portugal';
                $app->certificate_label = 'Portugal Criminal Record';
                return $app;
            });

        // Merge and sort recent applications
        $recentApplications = $ukRecentApplications->merge($ptRecentApplications)
            ->sortByDesc('created_at')
            ->take(5);

        // Get UK applications needing action (payment pending)
        $ukNeedsAction = PoliceCertificateApplication::where('user_id', $user->id)
            ->where('status', 'submitted')
            ->get()
            ->map(function ($app) {
                $app->certificate_type = 'uk';
                return $app;
            });

        // Get Portugal applications needing action (payment pending)
        $ptNeedsAction = PortugalCertificateApplication::where('user_id', $user->id)
            ->where('status', 'submitted')
            ->get()
            ->map(function ($app) {
                $app->certificate_type = 'portugal';
                return $app;
            });

        // Merge needs action
        $needsAction = $ukNeedsAction->merge($ptNeedsAction);

        return view('service-user.dashboard', compact(
            'totalApplications',
            'pendingApplications',
            'completedApplications',
            'processingApplications',
            'recentApplications',
            'draftApplications',
            'needsAction'
        ));
    }
}
