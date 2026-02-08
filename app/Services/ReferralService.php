<?php

namespace App\Services;

use App\Models\ReferralCode;
use App\Models\ReferralUse;
use App\Models\User;
use App\Models\Wallet;
use App\Mail\ReferralCreditAwarded;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class ReferralService
{
    public function getOrCreateReferralCode(User $user): ReferralCode
    {
        return $user->referralCode ?? ReferralCode::create([
            'user_id' => $user->id,
            'code' => ReferralCode::generateCode(),
            'max_uses' => config('referral.code_max_uses', 20),
        ]);
    }

    public function validateReferralCode(?string $code, User $user): array
    {
        if (empty($code)) {
            return ['valid' => true, 'message' => ''];
        }

        $referralCode = ReferralCode::where('code', $code)->first();

        if (!$referralCode) {
            return ['valid' => false, 'message' => 'Invalid referral code.'];
        }

        if ($referralCode->user_id === $user->id) {
            return ['valid' => false, 'message' => 'You cannot use your own referral code.'];
        }

        if (!$referralCode->isUsable()) {
            return ['valid' => false, 'message' => 'This referral code is no longer available.'];
        }

        return ['valid' => true, 'message' => 'Referral code applied! You and the referrer will each receive a bonus once your payment is verified.'];
    }

    public function recordReferralUse(string $code, User $user, string $appType, int $appId): ?ReferralUse
    {
        $referralCode = ReferralCode::where('code', $code)->first();

        if (!$referralCode || !$referralCode->isUsable() || $referralCode->user_id === $user->id) {
            return null;
        }

        // Check for existing use on this application
        $existing = ReferralUse::where('referred_user_id', $user->id)
            ->where('application_type', $appType)
            ->where('application_id', $appId)
            ->first();

        if ($existing) {
            return $existing;
        }

        return ReferralUse::create([
            'referral_code_id' => $referralCode->id,
            'referred_user_id' => $user->id,
            'application_type' => $appType,
            'application_id' => $appId,
            'status' => 'pending',
        ]);
    }

    public function processReferralCredits(string $appType, int $appId, User $referredUser): void
    {
        $referralUse = ReferralUse::where('referred_user_id', $referredUser->id)
            ->where('application_type', $appType)
            ->where('application_id', $appId)
            ->where('status', 'pending')
            ->first();

        if (!$referralUse) {
            return;
        }

        DB::transaction(function () use ($referralUse, $referredUser) {
            $creditAmount = config('referral.credit_amount', 5.00);
            $referralCode = $referralUse->referralCode;
            $referrerUser = $referralCode->user;

            // Credit the referrer
            $referrerWallet = $this->getOrCreateWallet($referrerUser);
            $referrerWallet->credit(
                $creditAmount,
                "Referral bonus - {$referredUser->name} used your code",
                'referral_bonus',
                $referralUse->id
            );

            // Credit the referred user
            $referredWallet = $this->getOrCreateWallet($referredUser);
            $referredWallet->credit(
                $creditAmount,
                "Welcome bonus - Used referral code {$referralCode->code}",
                'referral_bonus',
                $referralUse->id
            );

            // Mark as credited
            $referralUse->update([
                'status' => 'credited',
                'credited_at' => now(),
            ]);

            // Increment times_used
            $referralCode->increment('times_used');

            // Send email notifications
            Mail::to($referrerUser->email)->send(
                new ReferralCreditAwarded($referrerUser, $referredUser, $creditAmount, true)
            );

            Mail::to($referredUser->email)->send(
                new ReferralCreditAwarded($referredUser, $referrerUser, $creditAmount, false)
            );
        });
    }

    public function ensureReferralCodeOnPaymentVerified(User $user): ReferralCode
    {
        return $this->getOrCreateReferralCode($user);
    }

    public function requestBankPayout(User $user, float $amount, array $bankDetails): \App\Models\WithdrawalRequest
    {
        $wallet = $this->getOrCreateWallet($user);

        if (!$wallet->canWithdraw()) {
            throw new \RuntimeException('Minimum withdrawal amount is €' . config('referral.minimum_withdrawal', 50.00));
        }

        if ($amount > $wallet->balance) {
            throw new \RuntimeException('Insufficient wallet balance.');
        }

        return \App\Models\WithdrawalRequest::create([
            'wallet_id' => $wallet->id,
            'user_id' => $user->id,
            'amount' => $amount,
            'type' => 'bank_payout',
            'status' => 'pending',
            'bank_name' => $bankDetails['bank_name'] ?? null,
            'account_holder_name' => $bankDetails['account_holder_name'] ?? null,
            'iban' => $bankDetails['iban'] ?? null,
            'swift_bic' => $bankDetails['swift_bic'] ?? null,
        ]);
    }

    private function getOrCreateWallet(User $user): Wallet
    {
        return $user->wallet ?? Wallet::create([
            'user_id' => $user->id,
            'balance' => 0,
            'currency' => config('referral.currency', 'EUR'),
        ]);
    }
}
