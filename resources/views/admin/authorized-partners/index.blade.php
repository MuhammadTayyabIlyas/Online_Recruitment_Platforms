@extends('layouts.admin')

@section('title', 'Authorized Partners')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Header -->
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Authorized Partners</h1>
            <p class="text-sm text-gray-500 mt-1">Manage authorized partner agents</p>
        </div>
        <a href="{{ route('admin.authorized-partners.create') }}"
           class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-sm text-white hover:bg-indigo-700">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Add New Partner
        </a>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-2 md:grid-cols-5 gap-4 mb-6">
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4">
            <div class="text-sm text-gray-500">Total</div>
            <div class="text-2xl font-bold text-gray-900">{{ number_format($stats['total']) }}</div>
        </div>
        <div class="bg-white rounded-lg shadow-sm border border-green-200 p-4 bg-green-50">
            <div class="text-sm text-green-600">Active</div>
            <div class="text-2xl font-bold text-green-700">{{ number_format($stats['active']) }}</div>
        </div>
        <div class="bg-white rounded-lg shadow-sm border border-yellow-200 p-4 bg-yellow-50">
            <div class="text-sm text-yellow-600">Pending Review</div>
            <div class="text-2xl font-bold text-yellow-700">{{ number_format($stats['pending_review']) }}</div>
        </div>
        <div class="bg-white rounded-lg shadow-sm border border-orange-200 p-4 bg-orange-50">
            <div class="text-sm text-orange-600">Expired</div>
            <div class="text-2xl font-bold text-orange-700">{{ number_format($stats['expired']) }}</div>
        </div>
        <div class="bg-white rounded-lg shadow-sm border border-red-200 p-4 bg-red-50">
            <div class="text-sm text-red-600">Suspended</div>
            <div class="text-2xl font-bold text-red-700">{{ number_format($stats['suspended']) }}</div>
        </div>
    </div>

    <!-- Filters -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-6">
        <form action="{{ route('admin.authorized-partners.index') }}" method="GET">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                    <select name="status" id="status" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        <option value="">All Statuses</option>
                        <option value="pending_profile" {{ request('status') == 'pending_profile' ? 'selected' : '' }}>Pending Profile</option>
                        <option value="pending_review" {{ request('status') == 'pending_review' ? 'selected' : '' }}>Pending Review</option>
                        <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="suspended" {{ request('status') == 'suspended' ? 'selected' : '' }}>Suspended</option>
                        <option value="revoked" {{ request('status') == 'revoked' ? 'selected' : '' }}>Revoked</option>
                    </select>
                </div>
                <div>
                    <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Search</label>
                    <input type="text" name="search" id="search" value="{{ request('search') }}"
                           placeholder="Name, reference, email, tax ID..."
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                </div>
                <div class="flex items-end gap-2">
                    <button type="submit" class="px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-md hover:bg-indigo-700">
                        Filter
                    </button>
                    <a href="{{ route('admin.authorized-partners.index') }}" class="px-4 py-2 bg-gray-200 text-gray-700 text-sm font-medium rounded-md hover:bg-gray-300">
                        Reset
                    </a>
                </div>
            </div>
        </form>
    </div>

    <!-- Partners Table -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Reference</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">User / Business</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Countries</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Expires</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($partners as $partner)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-mono font-medium text-gray-900">
                            {{ $partner->reference_number }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">{{ $partner->user->name ?? 'N/A' }}</div>
                            <div class="text-sm text-gray-500">{{ $partner->business_name ?? 'No business name' }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($partner->authorized_countries)
                                <div class="flex flex-wrap gap-1">
                                    @foreach($partner->authorized_country_labels as $label)
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-indigo-100 text-indigo-800">{{ $label }}</span>
                                    @endforeach
                                </div>
                            @else
                                <span class="text-xs text-gray-400">Not assigned</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @php
                                $statusColors = [
                                    'pending_profile' => 'bg-gray-100 text-gray-800',
                                    'pending_review' => 'bg-yellow-100 text-yellow-800',
                                    'active' => 'bg-green-100 text-green-800',
                                    'suspended' => 'bg-orange-100 text-orange-800',
                                    'revoked' => 'bg-red-100 text-red-800',
                                ];
                                $colorClass = $statusColors[$partner->status] ?? 'bg-gray-100 text-gray-800';
                                if ($partner->status === 'active' && $partner->isExpired()) {
                                    $colorClass = 'bg-orange-100 text-orange-800';
                                }
                            @endphp
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $colorClass }}">
                                {{ $partner->status_label }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $partner->expires_at?->format('M d, Y') ?? '-' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            <a href="{{ route('admin.authorized-partners.show', $partner) }}" class="text-indigo-600 hover:text-indigo-900 font-medium">View</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                            No authorized partners found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        @if($partners->hasPages())
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $partners->withQueryString()->links() }}
            </div>
        @endif
    </div>
</div>

@if(session('success'))
    <div class="fixed bottom-4 right-4 bg-green-500 text-white px-6 py-4 rounded-lg shadow-xl z-50">
        <div class="flex items-center">
            <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <span class="font-medium">{{ session('success') }}</span>
        </div>
    </div>
    <script>setTimeout(() => { const t = document.querySelector('.fixed.bottom-4'); if (t) t.style.display = 'none'; }, 5000);</script>
@endif
@endsection
