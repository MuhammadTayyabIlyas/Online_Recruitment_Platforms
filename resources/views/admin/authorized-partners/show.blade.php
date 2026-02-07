@extends('layouts.admin')

@section('title', 'Partner - ' . $partner->reference_number)

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Header -->
    <div class="mb-6">
        <a href="{{ route('admin.authorized-partners.index') }}" class="inline-flex items-center text-indigo-600 hover:text-indigo-900 font-medium mb-4">
            <svg class="h-5 w-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
            Back to Partners
        </a>

        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <div class="flex items-start justify-between">
                <div class="flex items-center gap-4">
                    <div class="h-16 w-16 rounded-full bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center text-white font-bold text-2xl shadow-lg">
                        {{ strtoupper(substr($partner->user->name ?? 'P', 0, 1)) }}
                    </div>
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">{{ $partner->business_name ?? $partner->user->name }}</h1>
                        <p class="text-gray-600 flex items-center mt-1">
                            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                            Reference: <span class="font-mono font-semibold ml-1">{{ $partner->reference_number }}</span>
                        </p>
                        <p class="text-sm text-gray-500 mt-1">
                            User: <span class="font-medium">{{ $partner->user->name }}</span> ({{ $partner->user->email }})
                            @if($partner->expires_at)
                                | Expires: <span class="font-medium {{ $partner->isExpired() ? 'text-red-600' : '' }}">{{ $partner->expires_at->format('M d, Y') }}</span>
                            @endif
                        </p>
                    </div>
                </div>

                <div>
                    @php
                        $statusColors = [
                            'pending_profile' => 'bg-gray-100 text-gray-800 border-gray-300',
                            'pending_review' => 'bg-yellow-100 text-yellow-800 border-yellow-300',
                            'active' => 'bg-green-100 text-green-800 border-green-300',
                            'suspended' => 'bg-orange-100 text-orange-800 border-orange-300',
                            'revoked' => 'bg-red-100 text-red-800 border-red-300',
                        ];
                        $colorClass = $statusColors[$partner->status] ?? 'bg-gray-100 text-gray-800 border-gray-300';
                        if ($partner->status === 'active' && $partner->isExpired()) {
                            $colorClass = 'bg-orange-100 text-orange-800 border-orange-300';
                        }
                    @endphp
                    <span class="px-4 py-2 inline-flex text-sm font-bold rounded-full border-2 {{ $colorClass }}">
                        {{ $partner->status_label }}
                    </span>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Content -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Business Information -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
                <div class="bg-gradient-to-r from-indigo-50 to-purple-50 px-6 py-4 border-b border-gray-200">
                    <h2 class="text-lg font-bold text-gray-900 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                        </svg>
                        Business Information
                    </h2>
                </div>
                <div class="p-6">
                    @if($partner->business_name)
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <p class="text-xs text-gray-500 uppercase tracking-wide">Business Name</p>
                                <p class="text-sm font-medium text-gray-900">{{ $partner->business_name }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500 uppercase tracking-wide">Tax ID (CIF/NIF)</p>
                                <p class="text-sm font-medium text-gray-900 font-mono">{{ $partner->tax_id ?? 'N/A' }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500 uppercase tracking-wide">Email</p>
                                <p class="text-sm font-medium text-gray-900">{{ $partner->email ?? 'N/A' }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500 uppercase tracking-wide">Phone</p>
                                <p class="text-sm font-medium text-gray-900">{{ $partner->phone ?? 'N/A' }}</p>
                            </div>
                        </div>
                        <div class="mt-4 pt-4 border-t border-gray-200">
                            <p class="text-xs text-gray-500 uppercase tracking-wide mb-1">Address</p>
                            <p class="text-sm font-medium text-gray-900">
                                {{ $partner->address_line1 }}<br>
                                @if($partner->address_line2){{ $partner->address_line2 }}<br>@endif
                                {{ $partner->city }}, {{ $partner->postal_code }}<br>
                                {{ $partner->country }}
                            </p>
                        </div>
                    @else
                        <p class="text-gray-500 text-sm text-center py-4">Business profile not yet completed by the partner.</p>
                    @endif
                </div>
            </div>

            <!-- Authorized Countries -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
                <div class="bg-gradient-to-r from-green-50 to-teal-50 px-6 py-4 border-b border-gray-200">
                    <h2 class="text-lg font-bold text-gray-900 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        Authorized Countries / Services
                    </h2>
                </div>
                <div class="p-6">
                    @if($partner->authorized_countries && count($partner->authorized_countries) > 0)
                        <div class="flex flex-wrap gap-2">
                            @foreach($partner->authorized_country_labels as $label)
                                <span class="inline-flex items-center px-3 py-1.5 rounded-lg text-sm font-medium bg-green-100 text-green-800 border border-green-200">
                                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    {{ $label }}
                                </span>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-500 text-sm text-center py-4">No authorized countries assigned yet.</p>
                    @endif
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="lg:col-span-1">
            <div class="sticky top-4 space-y-6">
                <!-- Admin Actions -->
                <div class="bg-white rounded-lg shadow-lg border-2 border-red-300 overflow-hidden">
                    <div class="bg-gradient-to-r from-red-600 to-orange-600 px-6 py-4">
                        <h2 class="text-lg font-bold text-white flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                            </svg>
                            Admin Controls
                        </h2>
                    </div>

                    <div class="p-6 space-y-4">
                        @if ($errors->any())
                            <div class="bg-red-50 border-l-4 border-red-500 p-4 rounded">
                                <ul class="text-sm text-red-700 list-disc list-inside">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        @if($partner->status === 'pending_review')
                            <!-- Approve Form -->
                            <form action="{{ route('admin.authorized-partners.approve', $partner) }}" method="POST">
                                @csrf
                                <div class="mb-4">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Authorize for Countries</label>
                                    <div class="space-y-2">
                                        <label class="flex items-center">
                                            <input type="checkbox" name="authorized_countries[]" value="greece" class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500" checked>
                                            <span class="ml-2 text-sm text-gray-700">Greece</span>
                                        </label>
                                        <label class="flex items-center">
                                            <input type="checkbox" name="authorized_countries[]" value="portugal" class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500" checked>
                                            <span class="ml-2 text-sm text-gray-700">Portugal</span>
                                        </label>
                                        <label class="flex items-center">
                                            <input type="checkbox" name="authorized_countries[]" value="uk" class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500" checked>
                                            <span class="ml-2 text-sm text-gray-700">United Kingdom</span>
                                        </label>
                                    </div>
                                </div>
                                <div class="mb-4">
                                    <label for="approve_notes" class="block text-sm font-medium text-gray-700 mb-2">Admin Notes</label>
                                    <textarea name="admin_notes" id="approve_notes" rows="3" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm" placeholder="Optional approval notes..."></textarea>
                                </div>
                                <button type="submit" class="w-full inline-flex items-center justify-center px-6 py-3 bg-green-600 border border-transparent rounded-lg font-semibold text-sm text-white hover:bg-green-700 shadow-lg transition-colors">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    Approve Partner
                                </button>
                            </form>

                            <hr class="border-gray-200">

                            <!-- Revoke (reject) Form -->
                            <form action="{{ route('admin.authorized-partners.revoke', $partner) }}" method="POST">
                                @csrf
                                <div class="mb-4">
                                    <label for="reject_notes" class="block text-sm font-medium text-gray-700 mb-2">Rejection Reason</label>
                                    <textarea name="admin_notes" id="reject_notes" rows="2" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm" placeholder="Reason for rejection..."></textarea>
                                </div>
                                <button type="submit" class="w-full inline-flex items-center justify-center px-6 py-3 bg-red-600 border border-transparent rounded-lg font-semibold text-sm text-white hover:bg-red-700 shadow-lg transition-colors">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/>
                                    </svg>
                                    Reject / Revoke
                                </button>
                            </form>
                        @endif

                        @if($partner->status === 'active')
                            <!-- Renew -->
                            <form action="{{ route('admin.authorized-partners.renew', $partner) }}" method="POST">
                                @csrf
                                <button type="submit" class="w-full inline-flex items-center justify-center px-6 py-3 bg-blue-600 border border-transparent rounded-lg font-semibold text-sm text-white hover:bg-blue-700 shadow-lg transition-colors mb-2">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                                    </svg>
                                    Renew (+1 Year)
                                </button>
                            </form>

                            <!-- Suspend -->
                            <form action="{{ route('admin.authorized-partners.suspend', $partner) }}" method="POST">
                                @csrf
                                <div class="mb-4">
                                    <label for="suspend_notes" class="block text-sm font-medium text-gray-700 mb-2">Suspension Reason</label>
                                    <textarea name="admin_notes" id="suspend_notes" rows="2" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm" placeholder="Reason for suspension..."></textarea>
                                </div>
                                <button type="submit" class="w-full inline-flex items-center justify-center px-6 py-3 bg-orange-600 border border-transparent rounded-lg font-semibold text-sm text-white hover:bg-orange-700 shadow-lg transition-colors mb-2">
                                    Suspend Partner
                                </button>
                            </form>

                            <!-- Revoke -->
                            <form action="{{ route('admin.authorized-partners.revoke', $partner) }}" method="POST">
                                @csrf
                                <div class="mb-4">
                                    <label for="revoke_notes" class="block text-sm font-medium text-gray-700 mb-2">Revocation Reason</label>
                                    <textarea name="admin_notes" id="revoke_notes" rows="2" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm" placeholder="Reason for revocation..."></textarea>
                                </div>
                                <button type="submit" class="w-full inline-flex items-center justify-center px-6 py-3 bg-red-600 border border-transparent rounded-lg font-semibold text-sm text-white hover:bg-red-700 shadow-lg transition-colors">
                                    Revoke Partner
                                </button>
                            </form>
                        @endif

                        @if($partner->status === 'suspended')
                            <!-- Reactivate -->
                            <form action="{{ route('admin.authorized-partners.approve', $partner) }}" method="POST">
                                @csrf
                                <div class="mb-4">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Authorize for Countries</label>
                                    <div class="space-y-2">
                                        @foreach(['greece' => 'Greece', 'portugal' => 'Portugal', 'uk' => 'United Kingdom'] as $key => $label)
                                            <label class="flex items-center">
                                                <input type="checkbox" name="authorized_countries[]" value="{{ $key }}" class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500"
                                                    {{ in_array($key, $partner->authorized_countries ?? []) ? 'checked' : '' }}>
                                                <span class="ml-2 text-sm text-gray-700">{{ $label }}</span>
                                            </label>
                                        @endforeach
                                    </div>
                                </div>
                                <div class="mb-4">
                                    <label for="reactivate_notes" class="block text-sm font-medium text-gray-700 mb-2">Admin Notes</label>
                                    <textarea name="admin_notes" id="reactivate_notes" rows="2" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm" placeholder="Reactivation notes..."></textarea>
                                </div>
                                <button type="submit" class="w-full inline-flex items-center justify-center px-6 py-3 bg-green-600 border border-transparent rounded-lg font-semibold text-sm text-white hover:bg-green-700 shadow-lg transition-colors mb-2">
                                    Reactivate Partner
                                </button>
                            </form>

                            <!-- Revoke -->
                            <form action="{{ route('admin.authorized-partners.revoke', $partner) }}" method="POST">
                                @csrf
                                <button type="submit" class="w-full inline-flex items-center justify-center px-6 py-3 bg-red-600 border border-transparent rounded-lg font-semibold text-sm text-white hover:bg-red-700 shadow-lg transition-colors">
                                    Revoke Partner
                                </button>
                            </form>
                        @endif

                        @if($partner->status === 'pending_profile')
                            <div class="bg-gray-50 rounded-lg p-4 text-center">
                                <p class="text-sm text-gray-500">Waiting for the partner to complete their business profile.</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Certificate Download -->
                @if($partner->certificate_path && $partner->status === 'active')
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
                    <div class="bg-gradient-to-r from-indigo-50 to-blue-50 px-6 py-4 border-b border-gray-200">
                        <h2 class="text-lg font-bold text-gray-900 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                            </svg>
                            Partner Certificate
                        </h2>
                    </div>
                    <div class="p-6">
                        <a href="{{ route('admin.authorized-partners.certificate', $partner) }}"
                           class="w-full inline-flex items-center justify-center px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-lg hover:bg-indigo-700 transition-colors">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                            </svg>
                            Download Certificate PDF
                        </a>
                    </div>
                </div>
                @endif

                <!-- Admin Notes History -->
                @if($partner->admin_notes)
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
                    <div class="bg-gradient-to-r from-amber-50 to-yellow-50 px-6 py-4 border-b border-gray-200">
                        <h2 class="text-lg font-bold text-gray-900 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"/>
                            </svg>
                            Admin Notes
                        </h2>
                    </div>
                    <div class="p-6">
                        <div class="space-y-4">
                            @php
                                $notesList = explode("\n\n", $partner->admin_notes);
                                $notesList = array_reverse(array_filter($notesList));
                            @endphp

                            @foreach($notesList as $note)
                                @php
                                    preg_match('/\[(.+?) ([\d\-\s:]+)\]:\s*(.+)/s', $note, $matches);
                                    $adminName = $matches[1] ?? null;
                                    $timestamp = $matches[2] ?? null;
                                    $content = $matches[3] ?? $note;
                                @endphp

                                <div class="bg-gray-50 rounded-lg p-4 border-l-4 border-amber-500">
                                    @if($adminName && $timestamp)
                                        <div class="flex items-center text-xs text-gray-500 mb-2">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                            <span class="font-medium">{{ $adminName }}</span> - {{ \Carbon\Carbon::parse($timestamp)->format('M d, Y \a\t h:i A') }}
                                        </div>
                                    @endif
                                    <p class="text-sm text-gray-700 whitespace-pre-wrap">{{ trim($content) }}</p>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                @endif

                <!-- Timeline -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
                    <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
                        <h2 class="text-lg font-bold text-gray-900">Timeline</h2>
                    </div>
                    <div class="p-6 space-y-2 text-sm">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Created:</span>
                            <span class="font-medium text-gray-900">{{ $partner->created_at->format('M d, Y H:i') }}</span>
                        </div>
                        @if($partner->approved_at)
                        <div class="flex justify-between">
                            <span class="text-gray-600">Approved:</span>
                            <span class="font-medium text-gray-900">{{ $partner->approved_at->format('M d, Y') }}</span>
                        </div>
                        @endif
                        @if($partner->expires_at)
                        <div class="flex justify-between">
                            <span class="text-gray-600">Expires:</span>
                            <span class="font-medium {{ $partner->isExpired() ? 'text-red-600' : 'text-gray-900' }}">{{ $partner->expires_at->format('M d, Y') }}</span>
                        </div>
                        @endif
                        <div class="flex justify-between">
                            <span class="text-gray-600">Last Updated:</span>
                            <span class="font-medium text-gray-900">{{ $partner->updated_at->format('M d, Y H:i') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
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
