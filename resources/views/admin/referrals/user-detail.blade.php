@extends('layouts.admin')

@section('title', 'Referral Detail - ' . $user->name)
@section('page-title', 'Referral Detail: ' . $user->name)

@section('content')
<div class="space-y-6">
    <a href="{{ route('admin.referrals.index') }}" class="text-purple-600 hover:underline text-sm">&larr; Back to Referral Dashboard</a>

    <!-- User Info -->
    <div class="bg-white rounded-xl shadow-sm p-5 border border-gray-100">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 rounded-full bg-purple-100 flex items-center justify-center">
                <span class="text-purple-700 font-bold text-lg">{{ substr($user->name, 0, 1) }}</span>
            </div>
            <div>
                <h3 class="text-lg font-semibold text-gray-900">{{ $user->name }}</h3>
                <p class="text-sm text-gray-500">{{ $user->email }}</p>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <!-- Referral Code -->
        <div class="bg-white rounded-xl shadow-sm p-5 border border-gray-100">
            <p class="text-sm text-gray-500">Referral Code</p>
            @if($referralCode)
                <p class="text-xl font-mono font-bold text-purple-700">{{ $referralCode->code }}</p>
                <p class="text-xs text-gray-400 mt-1">{{ $referralCode->times_used }} / {{ $referralCode->max_uses }} uses | {{ $referralCode->is_active ? 'Active' : 'Inactive' }}</p>
            @else
                <p class="text-sm text-gray-400">No code yet</p>
            @endif
        </div>

        <!-- Wallet Balance -->
        <div class="bg-white rounded-xl shadow-sm p-5 border border-gray-100">
            <p class="text-sm text-gray-500">Wallet Balance</p>
            @if($wallet)
                <p class="text-xl font-bold text-gray-900">&euro;{{ number_format($wallet->balance, 2) }}</p>
            @else
                <p class="text-sm text-gray-400">No wallet</p>
            @endif
        </div>

        <!-- Total Earned -->
        <div class="bg-white rounded-xl shadow-sm p-5 border border-gray-100">
            <p class="text-sm text-gray-500">Total Earned</p>
            <p class="text-xl font-bold text-green-600">
                &euro;{{ $transactions->where('type', 'credit')->sum('amount') ? number_format($transactions->where('type', 'credit')->sum('amount'), 2) : '0.00' }}
            </p>
        </div>
    </div>

    <!-- Referral Uses -->
    @if($referralUses->count() > 0)
    <div class="bg-white rounded-xl shadow-sm border border-gray-100">
        <div class="p-5 border-b border-gray-100">
            <h3 class="text-lg font-semibold text-gray-900">Referral Uses ({{ $referralUses->count() }})</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
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
                        <td class="px-4 py-3 text-sm">{{ $use->referredUser->name }} ({{ $use->referredUser->email }})</td>
                        <td class="px-4 py-3 text-sm text-gray-600">{{ ucfirst(str_replace('-', ' ', $use->application_type)) }}</td>
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
    @if($transactions->count() > 0)
    <div class="bg-white rounded-xl shadow-sm border border-gray-100">
        <div class="p-5 border-b border-gray-100">
            <h3 class="text-lg font-semibold text-gray-900">Transaction History</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
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
    </div>
    @endif

    <!-- Withdrawal Requests -->
    @if($withdrawals->count() > 0)
    <div class="bg-white rounded-xl shadow-sm border border-gray-100">
        <div class="p-5 border-b border-gray-100">
            <h3 class="text-lg font-semibold text-gray-900">Withdrawal Requests</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Amount</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">IBAN</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Requested</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Processed</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($withdrawals as $w)
                    <tr>
                        <td class="px-4 py-3 text-sm font-semibold">&euro;{{ number_format($w->amount, 2) }}</td>
                        <td class="px-4 py-3 text-sm font-mono">{{ $w->iban }}</td>
                        <td class="px-4 py-3">
                            @switch($w->status)
                                @case('pending') <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">Pending</span> @break
                                @case('approved') <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">Approved</span> @break
                                @case('completed') <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">Completed</span> @break
                                @case('rejected') <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">Rejected</span> @break
                            @endswitch
                        </td>
                        <td class="px-4 py-3 text-sm text-gray-500">{{ $w->created_at->format('M d, Y') }}</td>
                        <td class="px-4 py-3 text-sm text-gray-500">
                            @if($w->processed_at)
                                {{ $w->processed_at->format('M d, Y') }}
                                @if($w->processor) by {{ $w->processor->name }} @endif
                            @else
                                -
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endif
</div>
@endsection
