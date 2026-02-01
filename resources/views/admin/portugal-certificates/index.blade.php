@extends('layouts.admin')

@section('title', 'Portugal Certificate Applications')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Header -->
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Portugal Certificate Applications</h1>
            <p class="text-sm text-gray-500 mt-1">Manage Portugal Criminal Record Certificate applications</p>
        </div>
        <a href="{{ route('admin.portugal-certificates.export', request()->query()) }}"
           class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-sm text-white hover:bg-green-700">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
            </svg>
            Export to CSV
        </a>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-7 gap-4 mb-6">
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4">
            <div class="text-sm text-gray-500">Total</div>
            <div class="text-2xl font-bold text-gray-900">{{ number_format($stats['total']) }}</div>
        </div>
        <div class="bg-white rounded-lg shadow-sm border border-blue-200 p-4 bg-blue-50">
            <div class="text-sm text-blue-600">Submitted</div>
            <div class="text-2xl font-bold text-blue-700">{{ number_format($stats['submitted']) }}</div>
        </div>
        <div class="bg-white rounded-lg shadow-sm border border-yellow-200 p-4 bg-yellow-50">
            <div class="text-sm text-yellow-600">Payment Pending</div>
            <div class="text-2xl font-bold text-yellow-700">{{ number_format($stats['payment_pending']) }}</div>
        </div>
        <div class="bg-white rounded-lg shadow-sm border border-green-200 p-4 bg-green-50">
            <div class="text-sm text-green-600">Payment Verified</div>
            <div class="text-2xl font-bold text-green-700">{{ number_format($stats['payment_verified']) }}</div>
        </div>
        <div class="bg-white rounded-lg shadow-sm border border-indigo-200 p-4 bg-indigo-50">
            <div class="text-sm text-indigo-600">Processing</div>
            <div class="text-2xl font-bold text-indigo-700">{{ number_format($stats['processing']) }}</div>
        </div>
        <div class="bg-white rounded-lg shadow-sm border border-emerald-200 p-4 bg-emerald-50">
            <div class="text-sm text-emerald-600">Completed</div>
            <div class="text-2xl font-bold text-emerald-700">{{ number_format($stats['completed']) }}</div>
        </div>
        <div class="bg-white rounded-lg shadow-sm border border-red-200 p-4 bg-red-50">
            <div class="text-sm text-red-600">Rejected</div>
            <div class="text-2xl font-bold text-red-700">{{ number_format($stats['rejected']) }}</div>
        </div>
    </div>

    <!-- Filters -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-6">
        <form action="{{ route('admin.portugal-certificates.index') }}" method="GET">
            <div class="grid grid-cols-1 md:grid-cols-6 gap-4">
                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                    <select name="status" id="status" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 sm:text-sm">
                        <option value="">All Statuses</option>
                        <option value="submitted" {{ request('status') == 'submitted' ? 'selected' : '' }}>Submitted</option>
                        <option value="payment_pending" {{ request('status') == 'payment_pending' ? 'selected' : '' }}>Payment Pending</option>
                        <option value="payment_verified" {{ request('status') == 'payment_verified' ? 'selected' : '' }}>Payment Verified</option>
                        <option value="processing" {{ request('status') == 'processing' ? 'selected' : '' }}>Processing</option>
                        <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                        <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                    </select>
                </div>

                <div>
                    <label for="service_type" class="block text-sm font-medium text-gray-700 mb-1">Service Type</label>
                    <select name="service_type" id="service_type" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 sm:text-sm">
                        <option value="">All Types</option>
                        <option value="normal" {{ request('service_type') == 'normal' ? 'selected' : '' }}>Normal (5-7 days)</option>
                        <option value="urgent" {{ request('service_type') == 'urgent' ? 'selected' : '' }}>Urgent (2-3 days)</option>
                    </select>
                </div>

                <div>
                    <label for="date_from" class="block text-sm font-medium text-gray-700 mb-1">From Date</label>
                    <input type="date" name="date_from" id="date_from" value="{{ request('date_from') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 sm:text-sm">
                </div>

                <div>
                    <label for="date_to" class="block text-sm font-medium text-gray-700 mb-1">To Date</label>
                    <input type="date" name="date_to" id="date_to" value="{{ request('date_to') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 sm:text-sm">
                </div>

                <div>
                    <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Search</label>
                    <input type="text" name="search" id="search" value="{{ request('search') }}" placeholder="Name, Email, Reference" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 sm:text-sm">
                </div>

                <div class="flex items-end gap-2">
                    <button type="submit" class="flex-1 bg-emerald-600 border border-transparent rounded-md shadow-sm py-2 px-4 text-sm font-medium text-white hover:bg-emerald-700">
                        Filter
                    </button>
                    @if(request()->hasAny(['status', 'service_type', 'search', 'date_from', 'date_to']))
                        <a href="{{ route('admin.portugal-certificates.index') }}" class="bg-gray-100 border border-gray-300 rounded-md shadow-sm py-2 px-4 text-sm font-medium text-gray-700 hover:bg-gray-200">
                            Clear
                        </a>
                    @endif
                </div>
            </div>
        </form>
    </div>

    <!-- Applications Table -->
    <div class="bg-white shadow-sm border border-gray-200 overflow-hidden sm:rounded-lg">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Reference</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Applicant</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Service</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Amount</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Submitted</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($applications as $application)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="text-sm font-mono font-medium text-emerald-600">{{ $application->application_reference }}</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="h-10 w-10 flex-shrink-0">
                                    <div class="h-10 w-10 rounded-full bg-gradient-to-br from-emerald-500 to-teal-600 flex items-center justify-center text-white font-bold">
                                        {{ strtoupper(substr($application->first_name, 0, 1)) }}
                                    </div>
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900">{{ $application->first_name }} {{ $application->last_name }}</div>
                                    <div class="text-sm text-gray-500">{{ $application->nationality }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">{{ $application->email }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @php
                                $statusColors = [
                                    'draft' => 'bg-gray-100 text-gray-800',
                                    'submitted' => 'bg-blue-100 text-blue-800',
                                    'payment_pending' => 'bg-yellow-100 text-yellow-800',
                                    'payment_verified' => 'bg-green-100 text-green-800',
                                    'processing' => 'bg-indigo-100 text-indigo-800',
                                    'completed' => 'bg-emerald-100 text-emerald-800',
                                    'rejected' => 'bg-red-100 text-red-800',
                                ];
                                $colorClass = $statusColors[$application->status] ?? 'bg-gray-100 text-gray-800';
                            @endphp
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $colorClass }}">
                                {{ $application->status_label }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="text-sm {{ $application->service_type === 'urgent' ? 'text-red-600 font-semibold' : 'text-gray-600' }}">
                                {{ $application->service_type === 'urgent' ? 'Urgent' : 'Normal' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 font-medium">
                            &euro;{{ number_format($application->payment_amount, 2) }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $application->submitted_at?->format('M d, Y') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <a href="{{ route('admin.portugal-certificates.show', $application) }}" class="text-emerald-600 hover:text-emerald-900">
                                View Details
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="px-6 py-12 text-center text-gray-500">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900">No applications found</h3>
                            <p class="mt-1 text-sm text-gray-500">Try adjusting your filters.</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <!-- Pagination -->
        @if($applications->hasPages())
            <div class="px-6 py-3 border-t border-gray-200 bg-gray-50">
                {{ $applications->withQueryString()->links() }}
            </div>
        @endif
    </div>
</div>

<!-- Success Toast -->
@if(session('success'))
    <div class="fixed bottom-4 right-4 bg-green-500 text-white px-6 py-4 rounded-lg shadow-xl z-50">
        <div class="flex items-center">
            <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <span class="font-medium">{{ session('success') }}</span>
        </div>
    </div>
    <script>
        setTimeout(() => {
            const toast = document.querySelector('.fixed.bottom-4');
            if (toast) toast.style.display = 'none';
        }, 5000);
    </script>
@endif
@endsection
