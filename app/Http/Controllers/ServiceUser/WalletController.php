<?php

namespace App\Http\Controllers\ServiceUser;

use App\Http\Controllers\Controller;
use App\Services\ReferralService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WalletController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $wallet = $user->getOrCreateWallet();
        $referralCode = $user->referralCode;
        $transactions = $wallet->transactions()->latest()->paginate(15);
        $referralUses = $referralCode ? $referralCode->referralUses()->with('referredUser')->latest()->get() : collect();
        $pendingWithdrawals = $wallet->withdrawalRequests()->where('status', 'pending')->exists();

        return view('service-user.wallet', compact(
            'wallet',
            'referralCode',
            'transactions',
            'referralUses',
            'pendingWithdrawals'
        ));
    }

    public function requestPayout(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:50',
            'bank_name' => 'required|string|max:255',
            'account_holder_name' => 'required|string|max:255',
            'iban' => 'required|string|max:50',
            'swift_bic' => 'nullable|string|max:20',
        ]);

        $user = Auth::user();
        $referralService = new ReferralService();

        try {
            $referralService->requestBankPayout($user, $request->amount, [
                'bank_name' => $request->bank_name,
                'account_holder_name' => $request->account_holder_name,
                'iban' => $request->iban,
                'swift_bic' => $request->swift_bic,
            ]);

            return redirect()->route('service_user.wallet')
                ->with('success', 'Withdrawal request submitted successfully. We will process it shortly.');
        } catch (\RuntimeException $e) {
            return redirect()->route('service_user.wallet')
                ->with('error', $e->getMessage());
        }
    }

    public function validateCode(Request $request)
    {
        $request->validate(['code' => 'required|string|max:10']);

        $referralService = new ReferralService();
        $result = $referralService->validateReferralCode($request->code, Auth::user());

        return response()->json($result);
    }
}
