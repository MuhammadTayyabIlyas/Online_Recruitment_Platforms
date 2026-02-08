<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ReferralCode;
use App\Models\ReferralUse;
use App\Models\User;
use App\Models\Wallet;
use App\Models\WalletTransaction;
use App\Models\WithdrawalRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReferralAdminController extends Controller
{
    public function index()
    {
        $stats = [
            'total_codes' => ReferralCode::count(),
            'active_codes' => ReferralCode::where('is_active', true)->count(),
            'total_uses' => ReferralUse::count(),
            'credited_uses' => ReferralUse::where('status', 'credited')->count(),
            'total_credits_given' => WalletTransaction::where('reference_type', 'referral_bonus')->sum('amount'),
            'pending_withdrawals' => WithdrawalRequest::where('status', 'pending')->count(),
            'total_withdrawn' => WithdrawalRequest::where('status', 'completed')->sum('amount'),
        ];

        $recentUses = ReferralUse::with(['referralCode.user', 'referredUser'])
            ->latest()
            ->take(10)
            ->get();

        $pendingWithdrawals = WithdrawalRequest::with('user')
            ->where('status', 'pending')
            ->latest()
            ->take(5)
            ->get();

        return view('admin.referrals.index', compact('stats', 'recentUses', 'pendingWithdrawals'));
    }

    public function referralCodes(Request $request)
    {
        $query = ReferralCode::with('user');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('code', 'like', "%{$search}%")
                  ->orWhereHas('user', function ($q) use ($search) {
                      $q->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                  });
            });
        }

        if ($request->filled('status')) {
            $query->where('is_active', $request->status === 'active');
        }

        $codes = $query->latest()->paginate(20)->withQueryString();

        return view('admin.referrals.codes', compact('codes'));
    }

    public function withdrawalRequests(Request $request)
    {
        $query = WithdrawalRequest::with(['user', 'processor']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $withdrawals = $query->latest()->paginate(20)->withQueryString();

        return view('admin.referrals.withdrawals', compact('withdrawals'));
    }

    public function processWithdrawal(Request $request, WithdrawalRequest $withdrawal)
    {
        $request->validate([
            'action' => 'required|in:approve,complete,reject',
            'admin_notes' => 'nullable|string|max:5000',
        ]);

        $action = $request->action;

        if ($action === 'approve' && $withdrawal->status === 'pending') {
            $withdrawal->update([
                'status' => 'approved',
                'processed_by' => Auth::id(),
                'processed_at' => now(),
                'admin_notes' => $request->admin_notes,
            ]);
        } elseif ($action === 'complete' && in_array($withdrawal->status, ['pending', 'approved'])) {
            // Debit the wallet
            $withdrawal->wallet->debit(
                $withdrawal->amount,
                "Bank payout processed - Withdrawal #{$withdrawal->id}",
                'payout',
                $withdrawal->id
            );

            $withdrawal->update([
                'status' => 'completed',
                'processed_by' => Auth::id(),
                'processed_at' => now(),
                'admin_notes' => $request->admin_notes,
            ]);
        } elseif ($action === 'reject' && in_array($withdrawal->status, ['pending', 'approved'])) {
            $withdrawal->update([
                'status' => 'rejected',
                'processed_by' => Auth::id(),
                'processed_at' => now(),
                'admin_notes' => $request->admin_notes,
            ]);
        }

        return redirect()->route('admin.referrals.withdrawals')
            ->with('success', 'Withdrawal request ' . $action . 'd successfully.');
    }

    public function userReferralDetail(User $user)
    {
        $referralCode = $user->referralCode;
        $wallet = $user->wallet;
        $referralUses = $referralCode ? $referralCode->referralUses()->with('referredUser')->latest()->get() : collect();
        $transactions = $wallet ? $wallet->transactions()->latest()->get() : collect();
        $withdrawals = $wallet ? $wallet->withdrawalRequests()->with('processor')->latest()->get() : collect();

        return view('admin.referrals.user-detail', compact('user', 'referralCode', 'wallet', 'referralUses', 'transactions', 'withdrawals'));
    }
}
