<?php

namespace App\Http\Controllers\ServiceUser;

use App\Http\Controllers\Controller;
use App\Http\Controllers\PoliceCertificateController;
use App\Models\PoliceCertificateApplication;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Get statistics
        $totalApplications = PoliceCertificateApplication::where('user_id', $user->id)->count();
        $pendingApplications = PoliceCertificateApplication::where('user_id', $user->id)
            ->whereIn('status', ['draft', 'submitted', 'payment_pending'])
            ->count();
        $completedApplications = PoliceCertificateApplication::where('user_id', $user->id)
            ->where('status', 'completed')
            ->count();
        $processingApplications = PoliceCertificateApplication::where('user_id', $user->id)
            ->whereIn('status', ['payment_verified', 'processing'])
            ->count();

        // Get draft applications (incomplete)
        $draftApplications = PoliceCertificateApplication::where('user_id', $user->id)
            ->where('status', 'draft')
            ->latest()
            ->get();

        // Add next step info to each draft
        $pccController = new PoliceCertificateController();
        foreach ($draftApplications as $draft) {
            $draft->next_step = $pccController->getNextStep($draft);
        }

        // Get recent applications (excluding drafts for main list)
        $recentApplications = PoliceCertificateApplication::where('user_id', $user->id)
            ->where('status', '!=', 'draft')
            ->latest()
            ->take(5)
            ->get();

        // Get applications needing action (payment pending)
        $needsAction = PoliceCertificateApplication::where('user_id', $user->id)
            ->where('status', 'submitted')
            ->get();

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
