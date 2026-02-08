@extends('layouts.app')

@section('title', 'My Wallet')

@section('content')
<div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">My Wallet</h1>
        <p class="mt-2 text-gray-600">Manage your referral earnings and withdrawals.</p>
    </div>

    @if(session('success'))
        <div class="mb-6 rounded-lg bg-green-50 p-4 border-l-4 border-green-500">
            <span class="text-green-700">{{ session('success') }}</span>
        </div>
    @endif

    @if(session('error'))
        <div class="mb-6 rounded-lg bg-red-50 p-4 border-l-4 border-red-500">
            <span class="text-red-700">{{ session('error') }}</span>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
        <!-- Wallet Balance Card -->
        <div class="bg-gradient-to-br from-purple-600 to-indigo-700 rounded-2xl p-6 text-white shadow-lg">
            <p class="text-purple-200 text-sm font-medium">Wallet Balance</p>
            <p class="text-4xl font-bold mt-2">&euro;{{ number_format($wallet->balance, 2) }}</p>
            <p class="text-purple-200 text-xs mt-2">{{ $wallet->currency }}</p>

            @if($wallet->canWithdraw() && !$pendingWithdrawals)
                <button onclick="document.getElementById('withdrawal-modal').classList.remove('hidden')"
                        class="mt-4 w-full bg-white text-purple-700 font-semibold py-2 px-4 rounded-lg hover:bg-purple-50 transition text-sm">
                    Request Withdrawal
                </button>
            @elseif($pendingWithdrawals)
                <p class="mt-4 text-purple-200 text-xs">You have a pending withdrawal request.</p>
            @else
                <p class="mt-4 text-purple-200 text-xs">Minimum &euro;{{ number_format(config('referral.minimum_withdrawal', 50), 2) }} required for withdrawal.</p>
            @endif
        </div>

        <!-- Referral Code Card -->
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-200 lg:col-span-2">
            <h3 class="text-lg font-semibold text-gray-900 mb-2">Your Referral Code</h3>
            @if($referralCode)
                <p class="text-sm text-gray-600 mb-4">Share this code with friends. When they use it and their payment is verified, you both get &euro;{{ number_format(config('referral.credit_amount', 5), 2) }}!</p>
                <div class="flex items-center gap-3" x-data="{ copied: false }">
                    <div class="flex-1 bg-gray-100 rounded-lg px-4 py-3 font-mono text-lg font-bold text-purple-700 tracking-wider">
                        {{ $referralCode->code }}
                    </div>
                    <button @click="navigator.clipboard.writeText('{{ $referralCode->code }}'); copied = true; setTimeout(() => copied = false, 2000)"
                            class="px-4 py-3 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition text-sm font-medium">
                        <span x-show="!copied">Copy</span>
                        <span x-show="copied" x-cloak>Copied!</span>
                    </button>
                </div>
                <p class="text-xs text-gray-500 mt-3">Used {{ $referralCode->times_used }} / {{ $referralCode->max_uses }} times</p>
            @else
                <div class="bg-gray-50 rounded-lg p-4">
                    <p class="text-sm text-gray-600">You'll receive your referral code once your first payment is verified.</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Referral History -->
    @if($referralUses->count() > 0)
    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 mb-8">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Referral History</h3>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead>
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Referred User</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Service</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($referralUses as $use)
                    <tr>
                        <td class="px-4 py-3 text-sm text-gray-900">{{ $use->referredUser->name }}</td>
                        <td class="px-4 py-3 text-sm text-gray-600">
                            @switch($use->application_type)
                                @case('greece') Greece Certificate @break
                                @case('portugal') Portugal Certificate @break
                                @case('uk-police') UK Police Certificate @break
                                @default {{ ucfirst($use->application_type) }}
                            @endswitch
                        </td>
                        <td class="px-4 py-3">
                            @if($use->status === 'credited')
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">Credited</span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">Pending</span>
                            @endif
                        </td>
                        <td class="px-4 py-3 text-sm text-gray-500">{{ $use->created_at->format('M d, Y') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endif

    <!-- Transaction History -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Transaction History</h3>
        @if($transactions->count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead>
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Description</th>
                            <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase">Amount</th>
                            <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase">Balance</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($transactions as $tx)
                        <tr>
                            <td class="px-4 py-3 text-sm text-gray-500">{{ $tx->created_at->format('M d, Y H:i') }}</td>
                            <td class="px-4 py-3 text-sm text-gray-900">{{ $tx->description }}</td>
                            <td class="px-4 py-3 text-sm text-right font-medium {{ $tx->type === 'credit' ? 'text-green-600' : 'text-red-600' }}">
                                {{ $tx->type === 'credit' ? '+' : '-' }}&euro;{{ number_format($tx->amount, 2) }}
                            </td>
                            <td class="px-4 py-3 text-sm text-right text-gray-600">&euro;{{ number_format($tx->balance_after, 2) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="mt-4">
                {{ $transactions->links() }}
            </div>
        @else
            <p class="text-sm text-gray-500 text-center py-8">No transactions yet.</p>
        @endif
    </div>
</div>

<!-- Withdrawal Modal -->
<div id="withdrawal-modal" class="hidden fixed inset-0 z-50 overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen px-4">
        <div class="fixed inset-0 bg-black/50" onclick="document.getElementById('withdrawal-modal').classList.add('hidden')"></div>
        <div class="relative bg-white rounded-2xl max-w-md w-full p-6 shadow-xl">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Request Bank Payout</h3>
            <form action="{{ route('service_user.wallet.request-payout') }}" method="POST">
                @csrf
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Amount (&euro;)</label>
                        <input type="number" name="amount" min="50" max="{{ $wallet->balance }}" step="0.01"
                               value="{{ $wallet->balance }}"
                               class="w-full rounded-lg border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500 text-sm" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Bank Name</label>
                        <input type="text" name="bank_name" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500 text-sm" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Account Holder Name</label>
                        <input type="text" name="account_holder_name" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500 text-sm" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">IBAN</label>
                        <input type="text" name="iban" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500 text-sm" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">SWIFT/BIC (optional)</label>
                        <input type="text" name="swift_bic" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500 text-sm">
                    </div>
                </div>
                <div class="flex gap-3 mt-6">
                    <button type="button" onclick="document.getElementById('withdrawal-modal').classList.add('hidden')"
                            class="flex-1 px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition text-sm font-medium">
                        Cancel
                    </button>
                    <button type="submit" class="flex-1 px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition text-sm font-medium">
                        Submit Request
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
