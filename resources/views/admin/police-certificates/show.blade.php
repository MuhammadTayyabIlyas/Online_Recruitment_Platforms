@extends('layouts.admin')

@section('title', 'Police Certificate - ' . $application->application_reference)

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Header -->
    <div class="mb-6">
        <a href="{{ route('admin.police-certificates.index') }}" class="inline-flex items-center text-indigo-600 hover:text-indigo-900 font-medium mb-4">
            <svg class="h-5 w-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
            Back to Applications
        </a>

        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <div class="flex items-start justify-between">
                <div class="flex items-center gap-4">
                    <div class="h-16 w-16 rounded-full bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center text-white font-bold text-2xl shadow-lg">
                        {{ strtoupper(substr($application->first_name, 0, 1)) }}
                    </div>
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">{{ $application->full_name }}</h1>
                        <p class="text-gray-600 flex items-center mt-1">
                            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                            Reference: <span class="font-mono font-semibold ml-1">{{ $application->application_reference }}</span>
                        </p>
                        <p class="text-sm text-gray-500 mt-1">
                            Service: <span class="font-medium {{ $application->service_type === 'urgent' ? 'text-red-600' : '' }}">{{ $application->service_type_label }}</span> |
                            Amount: <span class="font-medium">{{ $application->payment_amount_display }}</span>
                            @if($application->apostille_required)
                                | <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-amber-100 text-amber-800">Apostille</span>
                            @endif
                            | Submitted {{ $application->submitted_at?->diffForHumans() }}
                        </p>
                    </div>
                </div>

                <div>
                    @php
                        $statusColors = [
                            'draft' => 'bg-gray-100 text-gray-800 border-gray-300',
                            'submitted' => 'bg-blue-100 text-blue-800 border-blue-300',
                            'payment_pending' => 'bg-yellow-100 text-yellow-800 border-yellow-300',
                            'payment_verified' => 'bg-green-100 text-green-800 border-green-300',
                            'processing' => 'bg-indigo-100 text-indigo-800 border-indigo-300',
                            'completed' => 'bg-emerald-100 text-emerald-800 border-emerald-300',
                            'rejected' => 'bg-red-100 text-red-800 border-red-300',
                        ];
                        $colorClass = $statusColors[$application->status] ?? 'bg-gray-100 text-gray-800 border-gray-300';
                    @endphp
                    <span class="px-4 py-2 inline-flex text-sm font-bold rounded-full border-2 {{ $colorClass }}">
                        {{ $application->status_label }}
                    </span>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Content -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Personal Information -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
                <div class="bg-gradient-to-r from-indigo-50 to-purple-50 px-6 py-4 border-b border-gray-200">
                    <h2 class="text-lg font-bold text-gray-900 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                        Personal Information
                    </h2>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <p class="text-xs text-gray-500 uppercase tracking-wide">Full Name</p>
                            <p class="text-sm font-medium text-gray-900">{{ $application->full_name }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500 uppercase tracking-wide">Father's Name</p>
                            <p class="text-sm font-medium text-gray-900">{{ $application->father_full_name ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500 uppercase tracking-wide">Gender</p>
                            <p class="text-sm font-medium text-gray-900">{{ ucfirst($application->gender ?? 'N/A') }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500 uppercase tracking-wide">Date of Birth</p>
                            <p class="text-sm font-medium text-gray-900">{{ $application->date_of_birth?->format('M d, Y') ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500 uppercase tracking-wide">Place of Birth</p>
                            <p class="text-sm font-medium text-gray-900">{{ $application->place_of_birth_city }}, {{ $application->place_of_birth_country }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500 uppercase tracking-wide">Nationality</p>
                            <p class="text-sm font-medium text-gray-900">{{ $application->nationality ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500 uppercase tracking-wide">Marital Status</p>
                            <p class="text-sm font-medium text-gray-900">{{ ucfirst($application->marital_status ?? 'N/A') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Identity Documents -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
                <div class="bg-gradient-to-r from-amber-50 to-orange-50 px-6 py-4 border-b border-gray-200">
                    <h2 class="text-lg font-bold text-gray-900 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"/>
                        </svg>
                        Identity Documents
                    </h2>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <p class="text-xs text-gray-500 uppercase tracking-wide">Passport Number</p>
                            <p class="text-sm font-medium text-gray-900 font-mono">{{ $application->passport_number ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500 uppercase tracking-wide">Passport Issue Date</p>
                            <p class="text-sm font-medium text-gray-900">{{ $application->passport_issue_date?->format('M d, Y') ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500 uppercase tracking-wide">Passport Expiry Date</p>
                            <p class="text-sm font-medium text-gray-900">{{ $application->passport_expiry_date?->format('M d, Y') ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500 uppercase tracking-wide">Passport Place of Issue</p>
                            <p class="text-sm font-medium text-gray-900">{{ $application->passport_place_of_issue ?? 'N/A' }}</p>
                        </div>
                        @if($application->cnic_nicop_number)
                        <div>
                            <p class="text-xs text-gray-500 uppercase tracking-wide">CNIC/NICOP Number</p>
                            <p class="text-sm font-medium text-gray-900 font-mono">{{ $application->cnic_nicop_number }}</p>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- UK Information -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
                <div class="bg-gradient-to-r from-blue-50 to-cyan-50 px-6 py-4 border-b border-gray-200">
                    <h2 class="text-lg font-bold text-gray-900 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 21v-4m0 0V5a2 2 0 012-2h6.5l1 1H21l-3 6 3 6h-8.5l-1-1H5a2 2 0 00-2 2zm9-13.5V9"/>
                        </svg>
                        UK Information
                    </h2>
                </div>
                <div class="p-6 space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @if($application->uk_home_office_ref)
                        <div>
                            <p class="text-xs text-gray-500 uppercase tracking-wide">Home Office Reference</p>
                            <p class="text-sm font-medium text-gray-900 font-mono">{{ $application->uk_home_office_ref }}</p>
                        </div>
                        @endif
                        @if($application->uk_brp_number)
                        <div>
                            <p class="text-xs text-gray-500 uppercase tracking-wide">BRP Number</p>
                            <p class="text-sm font-medium text-gray-900 font-mono">{{ $application->uk_brp_number }}</p>
                        </div>
                        @endif
                        @if($application->uk_national_insurance_number)
                        <div>
                            <p class="text-xs text-gray-500 uppercase tracking-wide">National Insurance Number</p>
                            <p class="text-sm font-medium text-gray-900 font-mono">{{ $application->uk_national_insurance_number }}</p>
                        </div>
                        @endif
                    </div>

                    @if($application->uk_residence_history && count($application->uk_residence_history) > 0)
                    <div class="mt-4">
                        <p class="text-xs text-gray-500 uppercase tracking-wide mb-2">UK Residence History</p>
                        <div class="space-y-2">
                            @foreach($application->uk_residence_history as $residence)
                            <div class="bg-gray-50 rounded-lg p-3 border border-gray-200">
                                <p class="text-sm text-gray-900">
                                    <span class="font-medium">{{ $residence['from_date'] ?? 'N/A' }}</span> to <span class="font-medium">{{ $residence['to_date'] ?? 'Present' }}</span>
                                </p>
                                @if(isset($residence['visa_type']))
                                <p class="text-xs text-gray-500">Visa: {{ $residence['visa_type'] }}</p>
                                @endif
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    @if($application->uk_address_history && count($application->uk_address_history) > 0)
                    <div class="mt-4">
                        <p class="text-xs text-gray-500 uppercase tracking-wide mb-2">UK Address History</p>
                        <div class="space-y-2">
                            @foreach($application->uk_address_history as $address)
                            <div class="bg-gray-50 rounded-lg p-3 border border-gray-200">
                                <p class="text-sm text-gray-900 font-medium">{{ $address['address'] ?? 'N/A' }}</p>
                                <p class="text-xs text-gray-500">
                                    {{ $address['from_date'] ?? 'N/A' }} - {{ $address['to_date'] ?? 'Present' }}
                                </p>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Contact Information -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
                <div class="bg-gradient-to-r from-green-50 to-teal-50 px-6 py-4 border-b border-gray-200">
                    <h2 class="text-lg font-bold text-gray-900 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                        Contact & Spain Address
                    </h2>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <p class="text-xs text-gray-500 uppercase tracking-wide">Email</p>
                            <p class="text-sm font-medium text-gray-900">{{ $application->email }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500 uppercase tracking-wide">Phone (Spain)</p>
                            <p class="text-sm font-medium text-gray-900">{{ $application->phone_spain ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500 uppercase tracking-wide">WhatsApp</p>
                            <p class="text-sm font-medium text-gray-900">{{ $application->whatsapp_number ?? 'N/A' }}</p>
                        </div>
                    </div>
                    <div class="mt-4 pt-4 border-t border-gray-200">
                        <p class="text-xs text-gray-500 uppercase tracking-wide mb-1">Spain Address</p>
                        <p class="text-sm font-medium text-gray-900">
                            {{ $application->spain_address_line1 }}<br>
                            @if($application->spain_address_line2){{ $application->spain_address_line2 }}<br>@endif
                            {{ $application->spain_city }}, {{ $application->spain_province }} {{ $application->spain_postal_code }}
                        </p>
                    </div>
                </div>
            </div>

            <!-- Uploaded Documents -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
                <div class="bg-gradient-to-r from-purple-50 to-pink-50 px-6 py-4 border-b border-gray-200 flex justify-between items-center">
                    <h2 class="text-lg font-bold text-gray-900 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                        </svg>
                        Uploaded Documents ({{ $application->documents->count() }})
                    </h2>
                    @if($application->documents->count() > 0)
                    <a href="{{ route('admin.police-certificate.download-documents', $application) }}"
                       class="inline-flex items-center px-3 py-1.5 bg-purple-600 text-white text-sm font-medium rounded-lg hover:bg-purple-700 transition-colors">
                        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                        </svg>
                        Download All
                    </a>
                    @endif
                </div>
                <div class="p-6">
                    @if($application->documents->count() > 0)
                        <div class="space-y-3">
                            @foreach($application->documents as $document)
                                <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg border border-gray-200 hover:border-purple-300 transition">
                                    <div class="flex items-center flex-1">
                                        <div class="h-10 w-10 rounded-lg bg-purple-100 flex items-center justify-center">
                                            @if(str_contains($document->mime_type, 'pdf'))
                                            <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                                            </svg>
                                            @elseif(str_contains($document->mime_type, 'image'))
                                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                            </svg>
                                            @else
                                            <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                                            </svg>
                                            @endif
                                        </div>
                                        <div class="ml-4">
                                            <p class="text-sm font-medium text-gray-900">{{ $document->original_filename }}</p>
                                            <p class="text-xs text-gray-500">
                                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-purple-100 text-purple-800 mr-2">
                                                    {{ $document->document_type_label }}
                                                </span>
                                                {{ $document->created_at->format('M d, Y') }}
                                            </p>
                                        </div>
                                    </div>
                                    <div class="flex gap-2">
                                        <a href="{{ route('admin.police-certificate.preview-document', $document) }}" target="_blank"
                                           class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition-colors"
                                           title="View document">
                                            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                            </svg>
                                            View
                                        </a>
                                        <a href="{{ route('admin.police-certificate.download-document', $document) }}"
                                           class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-lg hover:bg-indigo-700 transition-colors"
                                           title="Download document">
                                            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                                            </svg>
                                            Download
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-500 text-sm text-center py-4">No documents uploaded yet.</p>
                    @endif
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="lg:col-span-1">
            <div class="sticky top-4 space-y-6">
                <!-- Admin Status Control -->
                <div class="bg-white rounded-lg shadow-lg border-2 border-red-300 overflow-hidden">
                    <div class="bg-gradient-to-r from-red-600 to-orange-600 px-6 py-4">
                        <h2 class="text-lg font-bold text-white flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                            </svg>
                            Admin Controls
                        </h2>
                    </div>

                    <form action="{{ route('admin.police-certificates.update-status', $application) }}" method="POST" class="p-6 space-y-4">
                        @csrf
                        @method('PATCH')

                        @if ($errors->any())
                            <div class="bg-red-50 border-l-4 border-red-500 p-4 rounded">
                                <div class="flex">
                                    <div class="flex-shrink-0">
                                        <svg class="h-5 w-5 text-red-400" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                                        </svg>
                                    </div>
                                    <div class="ml-3">
                                        <h3 class="text-sm font-medium text-red-800">Validation errors</h3>
                                        <ul class="mt-2 text-sm text-red-700 list-disc list-inside">
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <div>
                            <label for="status" class="block text-sm font-medium text-gray-700 mb-2">Update Status</label>
                            <select name="status" id="status" class="mt-1 block w-full pl-3 pr-10 py-2.5 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 rounded-lg">
                                <option value="submitted" {{ $application->status == 'submitted' ? 'selected' : '' }}>Submitted</option>
                                <option value="payment_pending" {{ $application->status == 'payment_pending' ? 'selected' : '' }}>Payment Pending</option>
                                <option value="payment_verified" {{ $application->status == 'payment_verified' ? 'selected' : '' }}>Payment Verified</option>
                                <option value="processing" {{ $application->status == 'processing' ? 'selected' : '' }}>Processing</option>
                                <option value="completed" {{ $application->status == 'completed' ? 'selected' : '' }}>Completed</option>
                                <option value="rejected" {{ $application->status == 'rejected' ? 'selected' : '' }}>Rejected</option>
                            </select>
                        </div>

                        <div>
                            <label for="admin_notes" class="block text-sm font-medium text-gray-700 mb-2">
                                Add Admin Note
                                <span class="text-xs text-gray-500 font-normal">(timestamped)</span>
                            </label>
                            <textarea name="admin_notes" id="admin_notes" rows="4" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm" placeholder="Add internal note about this application..."></textarea>
                            <p class="mt-1 text-xs text-gray-500">Note will be saved with your name and timestamp</p>
                        </div>

                        <button type="submit" class="w-full inline-flex items-center justify-center px-6 py-3 bg-red-600 border border-transparent rounded-lg font-semibold text-sm text-white hover:bg-red-700 shadow-lg transition-colors">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            Update Application
                        </button>
                    </form>
                </div>

                <!-- Payment PDF Document -->
                @php
                    $paymentPdfDoc = $application->documents()->where('document_type', 'payment_details')->first();
                @endphp
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
                    <div class="bg-gradient-to-r from-indigo-50 to-blue-50 px-6 py-4 border-b border-gray-200">
                        <h2 class="text-lg font-bold text-gray-900 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                            </svg>
                            Payment Details PDF
                        </h2>
                    </div>
                    <div class="p-6">
                        @if($paymentPdfDoc)
                            <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg border border-gray-200">
                                <div class="flex items-center">
                                    <div class="h-10 w-10 rounded-lg bg-red-100 flex items-center justify-center">
                                        <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                                        </svg>
                                    </div>
                                    <div class="ml-4">
                                        <p class="text-sm font-medium text-gray-900">{{ $paymentPdfDoc->original_filename }}</p>
                                        <p class="text-xs text-gray-500">Generated {{ $paymentPdfDoc->created_at->format('M d, Y H:i') }}</p>
                                    </div>
                                </div>
                                <div class="flex gap-2">
                                    <a href="{{ route('admin.police-certificate.preview-document', $paymentPdfDoc) }}" target="_blank"
                                       class="inline-flex items-center px-3 py-1.5 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition-colors">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                        </svg>
                                        View
                                    </a>
                                    <a href="{{ route('admin.police-certificate.download-document', $paymentPdfDoc) }}"
                                       class="inline-flex items-center px-3 py-1.5 bg-indigo-600 text-white text-sm font-medium rounded-lg hover:bg-indigo-700 transition-colors">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                                        </svg>
                                        Download
                                    </a>
                                </div>
                            </div>
                        @else
                            <p class="text-gray-500 text-sm text-center py-4">Payment PDF not generated yet.</p>
                        @endif
                    </div>
                </div>

                <!-- Payment Information -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
                    <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
                        <h2 class="text-lg font-bold text-gray-900 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/>
                            </svg>
                            Payment Info
                        </h2>
                    </div>
                    <div class="p-6 space-y-3 text-sm">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Amount:</span>
                            <span class="font-bold text-gray-900">{{ $application->payment_amount_display }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Status:</span>
                            <span class="font-medium {{ $application->payment_verified_at ? 'text-green-600' : 'text-yellow-600' }}">
                                {{ $application->payment_verified_at ? 'Verified' : 'Pending' }}
                            </span>
                        </div>
                        @if($application->payment_verified_at)
                        <div class="flex justify-between">
                            <span class="text-gray-600">Verified At:</span>
                            <span class="font-medium text-gray-900">{{ $application->payment_verified_at->format('M d, Y H:i') }}</span>
                        </div>
                        @endif
                        @if($application->verifier)
                        <div class="flex justify-between">
                            <span class="text-gray-600">Verified By:</span>
                            <span class="font-medium text-gray-900">{{ $application->verifier->name }}</span>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Admin Notes History -->
                @if($application->admin_notes)
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
                                $notesList = explode("\n\n", $application->admin_notes);
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

                <!-- Timestamps -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
                    <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
                        <h2 class="text-lg font-bold text-gray-900">Timeline</h2>
                    </div>
                    <div class="p-6 space-y-2 text-sm">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Created:</span>
                            <span class="font-medium text-gray-900">{{ $application->created_at->format('M d, Y H:i') }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Submitted:</span>
                            <span class="font-medium text-gray-900">{{ $application->submitted_at?->format('M d, Y H:i') ?? 'Not submitted' }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Last Updated:</span>
                            <span class="font-medium text-gray-900">{{ $application->updated_at->format('M d, Y H:i') }}</span>
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
    <script>
        setTimeout(() => {
            const toast = document.querySelector('.fixed.bottom-4');
            if (toast) toast.style.display = 'none';
        }, 5000);
    </script>
@endif
@endsection
