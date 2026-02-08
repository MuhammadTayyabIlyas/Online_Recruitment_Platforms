@extends('layouts.admin')

@section('title', 'Referral Program')
@section('page-title', 'Referral Program Dashboard')

@section('content')
<div class="space-y-6">
    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <div class="bg-white rounded-xl shadow-sm p-5 border border-gray-100">
            <p class="text-sm text-gray-500">Total Codes</p>
            <p class="text-2xl font-bold text-gray-900">{{ $stats['total_codes'] }}</p>
            <p class="text-xs text-gray-400">{{ $stats['active_codes'] }} active</p>
        </div>
        <div class="bg-white rounded-xl shadow-sm p-5 border border-gray-100">
            <p class="text-sm text-gray-500">Total Referral Uses</p>
            <p class="text-2xl font-bold text-gray-900">{{ $stats['total_uses'] }}</p>
            <p class="text-xs text-gray-400">{{ $stats['credited_uses'] }} credited</p>
        </div>
        <div class="bg-white rounded-xl shadow-sm p-5 border border-gray-100">
            <p class="text-sm text-gray-500">Total Credits Given</p>
            <p class="text-2xl font-bold text-purple-700">&euro;{{ number_format($stats['total_credits_given'], 2) }}</p>
        </div>
        <div class="bg-white rounded-xl shadow-sm p-5 border border-gray-100">
            <p class="text-sm text-gray-500">Pending Withdrawals</p>
            <p class="text-2xl font-bold text-orange-600">{{ $stats['pending_withdrawals'] }}</p>
            <p class="text-xs text-gray-400">&euro;{{ number_format($stats['total_withdrawn'], 2) }} total paid</p>
        </div>
    </div>

    <!-- Quick Links -->
    <div class="flex gap-3">
        <a href="{{ route('admin.referrals.codes') }}" class="px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition text-sm font-medium">
            View All Codes
        </a>
        <a href="{{ route('admin.referrals.withdrawals') }}" class="px-4 py-2 bg-white border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition text-sm font-medium">
            Manage Withdrawals
            @if($stats['pending_withdrawals'] > 0)
                <span class="ml-1 inline-flex items-center justify-center px-2 py-0.5 rounded-full text-xs font-medium bg-orange-100 text-orange-800">{{ $stats['pending_withdrawals'] }}</span>
            @endif
        </a>
    </div>

    <!-- Recent Referral Uses -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100">
        <div class="p-5 border-b border-gray-100">
            <h3 class="text-lg font-semibold text-gray-900">Recent Referral Uses</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Referrer</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Code</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Referred User</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Service</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($recentUses as $use)
                    <tr>
                        <td class="px-4 py-3 text-sm">
                            <a href="{{ route('admin.referrals.user-detail', $use->referralCode->user) }}" class="text-purple-600 hover:underline">
                                {{ $use->referralCode->user->name }}
                            </a>
                        </td>
                        <td class="px-4 py-3 text-sm font-mono text-gray-600">{{ $use->referralCode->code }}</td>
                        <td class="px-4 py-3 text-sm">
                            <a href="{{ route('admin.referrals.user-detail', $use->referredUser) }}" class="text-purple-600 hover:underline">
                                {{ $use->referredUser->name }}
                            </a>
                        </td>
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
                    @empty
                    <tr>
                        <td colspan="6" class="px-4 py-8 text-center text-sm text-gray-500">No referral uses yet.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pending Withdrawals -->
    @if($pendingWithdrawals->count() > 0)
    <div class="bg-white rounded-xl shadow-sm border border-orange-200">
        <div class="p-5 border-b border-gray-100">
            <h3 class="text-lg font-semibold text-gray-900">Pending Withdrawal Requests</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">User</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Amount</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">IBAN</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Requested</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($pendingWithdrawals as $w)
                    <tr>
                        <td class="px-4 py-3 text-sm">{{ $w->user->name }}</td>
                        <td class="px-4 py-3 text-sm font-semibold">&euro;{{ number_format($w->amount, 2) }}</td>
                        <td class="px-4 py-3 text-sm font-mono text-gray-600">{{ $w->iban }}</td>
                        <td class="px-4 py-3 text-sm text-gray-500">{{ $w->created_at->format('M d, Y') }}</td>
                        <td class="px-4 py-3">
                            <a href="{{ route('admin.referrals.withdrawals') }}" class="text-purple-600 hover:underline text-sm">Manage</a>
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
