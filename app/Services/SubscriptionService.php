<?php

namespace App\Services;

use App\Models\Package;
use App\Models\PackageSubscription;
use App\Models\User;

class SubscriptionService
{
    public function createSubscription(User $user, Package $package, float $amountPaid): PackageSubscription
    {
        // Expire any existing active subscriptions
        $user->subscriptions()->active()->update(['status' => 'expired']);

        return PackageSubscription::create([
            'user_id' => $user->id,
            'package_id' => $package->id,
            'amount_paid' => $amountPaid,
            'jobs_remaining' => $package->job_posts_limit,
            'featured_jobs_remaining' => $package->featured_jobs_limit,
            'cv_access_remaining' => $package->cv_access_limit,
            'status' => 'active',
            'starts_at' => now(),
            'expires_at' => now()->addDays($package->duration_days),
        ]);
    }

    public function getActiveSubscription(User $user): ?PackageSubscription
    {
        return $user->subscriptions()->active()->with('package')->first();
    }

    public function canPostJob(User $user): bool
    {
        $subscription = $this->getActiveSubscription($user);
        return $subscription && $subscription->hasJobCredits();
    }

    public function canAccessCv(User $user): bool
    {
        $subscription = $this->getActiveSubscription($user);
        return $subscription && $subscription->hasCvCredits();
    }

    public function useJobCredit(User $user): bool
    {
        $subscription = $this->getActiveSubscription($user);
        return $subscription ? $subscription->useJobCredit() : false;
    }

    public function useCvCredit(User $user): bool
    {
        $subscription = $this->getActiveSubscription($user);
        return $subscription ? $subscription->useCvCredit() : false;
    }

    public function expireSubscriptions(): int
    {
        return PackageSubscription::where('status', 'active')
            ->where('expires_at', '<', now())
            ->update(['status' => 'expired']);
    }
}
