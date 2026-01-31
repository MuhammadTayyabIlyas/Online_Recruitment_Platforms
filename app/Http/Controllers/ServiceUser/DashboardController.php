<?php

namespace App\Http\Controllers\ServiceUser;

use App\Http\Controllers\Controller;
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

        // Get recent applications
        $recentApplications = PoliceCertificateApplication::where('user_id', $user->id)
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
            'needsAction'
        ));
    }
}
