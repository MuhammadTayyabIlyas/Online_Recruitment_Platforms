<?php

namespace App\Http\Controllers;

use App\Models\Package;
use App\Models\Payment;
use App\Services\SubscriptionService;
use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\PaymentIntent;

class PaymentController extends Controller
{
    public function __construct(protected SubscriptionService $subscriptionService)
    {
        // Middleware is applied in routes
    }

    public function checkout(Package $package)
    {
        Stripe::setApiKey(config('services.stripe.secret'));

        $intent = PaymentIntent::create([
            'amount' => $package->price * 100,
            'currency' => 'usd',
            'metadata' => [
                'package_id' => $package->id,
                'user_id' => auth()->id(),
            ],
        ]);

        $payment = Payment::create([
            'user_id' => auth()->id(),
            'package_id' => $package->id,
            'stripe_payment_intent_id' => $intent->id,
            'amount' => $package->price,
            'currency' => 'USD',
            'status' => 'pending',
        ]);

        return view('payment.checkout', [
            'package' => $package,
            'clientSecret' => $intent->client_secret,
            'payment' => $payment,
        ]);
    }

    public function success(Request $request)
    {
        $payment = Payment::where('stripe_payment_intent_id', $request->payment_intent)->firstOrFail();

        if ($payment->status !== 'completed') {
            $payment->markCompleted();

            $subscription = $this->subscriptionService->createSubscription(
                $payment->user,
                $payment->package,
                $payment->amount
            );

            $payment->update(['subscription_id' => $subscription->id]);
        }

        return view('payment.success', compact('payment'));
    }

    public function history()
    {
        $payments = auth()->user()->payments()->with('package')->latest()->paginate(20);
        return view('payment.history', compact('payments'));
    }

    public function packages()
    {
        $packages = Package::where('is_active', true)->where('id', '<=', 3)->orderBy('sort_order', 'asc')->get();
        $hasCompany = auth()->user()->company()->exists();
        $isApproved = auth()->user()->company?->is_cv_access_approved ?? false;

        return view('employer.packages', compact('packages', 'hasCompany', 'isApproved'));
    }

    public function subscription()
    {
        $subscription = auth()->user()->activeSubscription;
        $subscriptionHistory = auth()->user()->subscriptions()->with('package')->latest()->paginate(10);
        $hasCompany = auth()->user()->company()->exists();
        $isApproved = auth()->user()->company?->is_cv_access_approved ?? false;

        return view('employer.subscription', compact('subscription', 'subscriptionHistory', 'hasCompany', 'isApproved'));
    }
}
