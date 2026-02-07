@extends('layouts.app')

@section('title', 'Verify Authorized Partner')

@section('content')
<div class="max-w-2xl mx-auto py-10 px-4 sm:px-6 lg:px-8">
    @if($partner)
        @if($partner->isActive())
            <!-- Active Partner -->
            <div class="bg-white rounded-2xl shadow-lg border border-green-200 overflow-hidden">
                <div class="bg-gradient-to-r from-green-500 to-emerald-600 px-8 py-8 text-center">
                    <div class="mx-auto h-20 w-20 rounded-full bg-white/20 flex items-center justify-center mb-4">
                        <svg class="h-10 w-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <h1 class="text-2xl font-bold text-white">Verified Authorized Partner</h1>
                    <p class="text-green-100 mt-2">This partner is verified and currently active.</p>
                </div>

                <div class="p-8">
                    <div class="space-y-4">
                        <div class="flex justify-between items-center py-3 border-b border-gray-100">
                            <span class="text-sm text-gray-500">Business Name</span>
                            <span class="text-sm font-bold text-gray-900">{{ $partner->business_name }}</span>
                        </div>
                        <div class="flex justify-between items-center py-3 border-b border-gray-100">
                            <span class="text-sm text-gray-500">Location</span>
                            <span class="text-sm font-medium text-gray-900">{{ $partner->city }}{{ $partner->country ? ', ' . $partner->country : '' }}</span>
                        </div>
                        <div class="flex justify-between items-center py-3 border-b border-gray-100">
                            <span class="text-sm text-gray-500">Reference Number</span>
                            <span class="text-sm font-mono font-bold text-gray-900">{{ $partner->reference_number }}</span>
                        </div>
                        <div class="flex justify-between items-center py-3 border-b border-gray-100">
                            <span class="text-sm text-gray-500">Valid Until</span>
                            <span class="text-sm font-medium text-gray-900">{{ $partner->expires_at?->format('F d, Y') }}</span>
                        </div>
                        <div class="py-3">
                            <span class="text-sm text-gray-500 block mb-2">Authorized Services</span>
                            <div class="flex flex-wrap gap-2">
                                @foreach($partner->authorized_country_labels as $label)
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4"/>
                                        </svg>
                                        {{ $label }}
                                    </span>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @elseif($partner->status === 'active' && $partner->isExpired())
            <!-- Expired Partner -->
            <div class="bg-white rounded-2xl shadow-lg border border-orange-200 overflow-hidden">
                <div class="bg-gradient-to-r from-orange-400 to-amber-500 px-8 py-8 text-center">
                    <div class="mx-auto h-20 w-20 rounded-full bg-white/20 flex items-center justify-center mb-4">
                        <svg class="h-10 w-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <h1 class="text-2xl font-bold text-white">Partnership Expired</h1>
                    <p class="text-orange-100 mt-2">This partner's authorization has expired.</p>
                </div>

                <div class="p-8">
                    <div class="space-y-4">
                        <div class="flex justify-between items-center py-3 border-b border-gray-100">
                            <span class="text-sm text-gray-500">Business Name</span>
                            <span class="text-sm font-bold text-gray-900">{{ $partner->business_name }}</span>
                        </div>
                        <div class="flex justify-between items-center py-3 border-b border-gray-100">
                            <span class="text-sm text-gray-500">Reference Number</span>
                            <span class="text-sm font-mono font-bold text-gray-900">{{ $partner->reference_number }}</span>
                        </div>
                        <div class="flex justify-between items-center py-3">
                            <span class="text-sm text-gray-500">Expired On</span>
                            <span class="text-sm font-medium text-orange-600">{{ $partner->expires_at?->format('F d, Y') }}</span>
                        </div>
                    </div>

                    <div class="mt-6 bg-orange-50 border-l-4 border-orange-400 p-4 rounded-r-lg">
                        <p class="text-sm text-orange-700">
                            This partner's authorization is no longer valid. Please contact PlaceMeNet for updated information.
                        </p>
                    </div>
                </div>
            </div>
        @else
            <!-- Suspended / Revoked / Other -->
            <div class="bg-white rounded-2xl shadow-lg border border-red-200 overflow-hidden">
                <div class="bg-gradient-to-r from-red-500 to-rose-600 px-8 py-8 text-center">
                    <div class="mx-auto h-20 w-20 rounded-full bg-white/20 flex items-center justify-center mb-4">
                        <svg class="h-10 w-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </div>
                    <h1 class="text-2xl font-bold text-white">Not a Verified Partner</h1>
                    <p class="text-red-100 mt-2">This partner is not currently authorized.</p>
                </div>

                <div class="p-8 text-center">
                    <p class="text-gray-600">
                        The reference <span class="font-mono font-bold">{{ $reference }}</span> does not correspond to an active authorized partner.
                    </p>
                </div>
            </div>
        @endif
    @else
        <!-- Not Found -->
        <div class="bg-white rounded-2xl shadow-lg border border-red-200 overflow-hidden">
            <div class="bg-gradient-to-r from-red-500 to-rose-600 px-8 py-8 text-center">
                <div class="mx-auto h-20 w-20 rounded-full bg-white/20 flex items-center justify-center mb-4">
                    <svg class="h-10 w-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </div>
                <h1 class="text-2xl font-bold text-white">Not a Verified Partner</h1>
                <p class="text-red-100 mt-2">This reference was not found in our system.</p>
            </div>

            <div class="p-8 text-center">
                <p class="text-gray-600">
                    The reference <span class="font-mono font-bold">{{ $reference }}</span> does not match any authorized partner in our records.
                </p>
                <p class="text-sm text-gray-400 mt-4">
                    If you believe this is an error, please contact us at
                    <a href="mailto:info@placemenet.com" class="text-indigo-600 hover:text-indigo-800">info@placemenet.com</a>.
                </p>
            </div>
        </div>
    @endif

    <!-- Back to Directory -->
    <div class="mt-8 text-center">
        <a href="{{ route('partners.directory') }}" class="inline-flex items-center text-indigo-600 hover:text-indigo-800 font-medium">
            <svg class="h-5 w-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
            View All Partners
        </a>
    </div>
</div>
@endsection
