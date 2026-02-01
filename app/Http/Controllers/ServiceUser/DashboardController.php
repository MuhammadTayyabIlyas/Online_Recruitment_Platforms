<?php

namespace App\Http\Controllers\ServiceUser;

use App\Http\Controllers\Controller;
use App\Http\Controllers\PoliceCertificateController;
use App\Http\Controllers\PortugalCertificateController;
use App\Http\Controllers\GreeceCertificateController;
use App\Models\PoliceCertificateApplication;
use App\Models\PortugalCertificateApplication;
use App\Models\GreeceCertificateApplication;
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

        // Greece Certificate Statistics
        $grTotalApplications = GreeceCertificateApplication::where('user_id', $user->id)->count();
        $grPendingApplications = GreeceCertificateApplication::where('user_id', $user->id)
            ->whereIn('status', ['draft', 'submitted', 'payment_pending'])
            ->count();
        $grCompletedApplications = GreeceCertificateApplication::where('user_id', $user->id)
            ->where('status', 'completed')
            ->count();
        $grProcessingApplications = GreeceCertificateApplication::where('user_id', $user->id)
            ->whereIn('status', ['payment_verified', 'processing'])
            ->count();

        // Combined statistics
        $totalApplications = $ukTotalApplications + $ptTotalApplications + $grTotalApplications;
        $pendingApplications = $ukPendingApplications + $ptPendingApplications + $grPendingApplications;
        $completedApplications = $ukCompletedApplications + $ptCompletedApplications + $grCompletedApplications;
        $processingApplications = $ukProcessingApplications + $ptProcessingApplications + $grProcessingApplications;

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

        // Get Greece draft applications (incomplete)
        $grDraftApplications = GreeceCertificateApplication::where('user_id', $user->id)
            ->where('status', 'draft')
            ->latest()
            ->get();

        // Add next step info to each Greece draft
        $grController = new GreeceCertificateController();
        foreach ($grDraftApplications as $draft) {
            $draft->next_step = $grController->getNextStep($draft);
            $draft->certificate_type = 'greece';
        }

        // Merge draft applications
        $draftApplications = $ukDraftApplications->merge($ptDraftApplications)->merge($grDraftApplications)->sortByDesc('created_at');

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

        // Get recent Greece applications (excluding drafts)
        $grRecentApplications = GreeceCertificateApplication::where('user_id', $user->id)
            ->where('status', '!=', 'draft')
            ->latest()
            ->take(5)
            ->get()
            ->map(function ($app) {
                $app->certificate_type = 'greece';
                $app->certificate_label = 'Greece Penal Record';
                return $app;
            });

        // Merge and sort recent applications
        $recentApplications = $ukRecentApplications->merge($ptRecentApplications)->merge($grRecentApplications)
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

        // Get Greece applications needing action (payment pending)
        $grNeedsAction = GreeceCertificateApplication::where('user_id', $user->id)
            ->where('status', 'submitted')
            ->get()
            ->map(function ($app) {
                $app->certificate_type = 'greece';
                return $app;
            });

        // Merge needs action
        $needsAction = $ukNeedsAction->merge($ptNeedsAction)->merge($grNeedsAction);

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
