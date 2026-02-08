@extends('layouts.admin')

@section('title', 'Withdrawal Requests')
@section('page-title', 'Withdrawal Requests')

@section('content')
<div class="space-y-6">
    @if(session('success'))
        <div class="rounded-lg bg-green-50 p-4 border-l-4 border-green-500">
            <span class="text-green-700">{{ session('success') }}</span>
        </div>
    @endif

    <!-- Filters -->
    <div class="bg-white rounded-xl shadow-sm p-5 border border-gray-100">
        <form method="GET" class="flex gap-4 items-end">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                <select name="status" class="rounded-lg border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500 text-sm">
                    <option value="">All</option>
                    <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="approved" {{ request('status') === 'approved' ? 'selected' : '' }}>Approved</option>
                    <option value="completed" {{ request('status') === 'completed' ? 'selected' : '' }}>Completed</option>
                    <option value="rejected" {{ request('status') === 'rejected' ? 'selected' : '' }}>Rejected</option>
                </select>
            </div>
            <button type="submit" class="px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition text-sm font-medium">Filter</button>
            <a href="{{ route('admin.referrals.withdrawals') }}" class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition text-sm">Reset</a>
        </form>
    </div>

    <!-- Withdrawals Table -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">ID</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">User</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Amount</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Bank Details</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Requested</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($withdrawals as $w)
                    <tr>
                        <td class="px-4 py-3 text-sm text-gray-500">#{{ $w->id }}</td>
                        <td class="px-4 py-3 text-sm">
                            <div>{{ $w->user->name }}</div>
                            <div class="text-xs text-gray-500">{{ $w->user->email }}</div>
                        </td>
                        <td class="px-4 py-3 text-sm font-semibold">&euro;{{ number_format($w->amount, 2) }}</td>
                        <td class="px-4 py-3 text-xs">
                            <div><strong>Bank:</strong> {{ $w->bank_name }}</div>
                            <div><strong>Name:</strong> {{ $w->account_holder_name }}</div>
                            <div><strong>IBAN:</strong> <span class="font-mono">{{ $w->iban }}</span></div>
                            @if($w->swift_bic)
                                <div><strong>SWIFT:</strong> <span class="font-mono">{{ $w->swift_bic }}</span></div>
                            @endif
                        </td>
                        <td class="px-4 py-3">
                            @switch($w->status)
                                @case('pending')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">Pending</span>
                                    @break
                                @case('approved')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">Approved</span>
                                    @break
                                @case('completed')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">Completed</span>
                                    @break
                                @case('rejected')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">Rejected</span>
                                    @break
                            @endswitch
                            @if($w->processor)
                                <div class="text-xs text-gray-400 mt-1">by {{ $w->processor->name }}</div>
                            @endif
                        </td>
                        <td class="px-4 py-3 text-sm text-gray-500">{{ $w->created_at->format('M d, Y') }}</td>
                        <td class="px-4 py-3">
                            @if(in_array($w->status, ['pending', 'approved']))
                                <div class="flex flex-col gap-1">
                                    @if($w->status === 'pending')
                                        <form method="POST" action="{{ route('admin.referrals.process-withdrawal', $w) }}">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="action" value="approve">
                                            <button type="submit" class="text-blue-600 hover:underline text-xs">Approve</button>
                                        </form>
                                    @endif
                                    <form method="POST" action="{{ route('admin.referrals.process-withdrawal', $w) }}">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="action" value="complete">
                                        <button type="submit" class="text-green-600 hover:underline text-xs">Mark Completed</button>
                                    </form>
                                    <form method="POST" action="{{ route('admin.referrals.process-withdrawal', $w) }}">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="action" value="reject">
                                        <button type="submit" class="text-red-600 hover:underline text-xs" onclick="return confirm('Are you sure?')">Reject</button>
                                    </form>
                                </div>
                            @else
                                <span class="text-xs text-gray-400">No actions</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-4 py-8 text-center text-sm text-gray-500">No withdrawal requests found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($withdrawals->hasPages())
            <div class="p-4 border-t border-gray-100">
                {{ $withdrawals->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
