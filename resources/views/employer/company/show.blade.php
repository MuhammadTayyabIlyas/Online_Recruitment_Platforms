@extends('layouts.employer')

@section('title', 'Company Profile')

@section('content')
<div class="max-w-4xl mx-auto py-8 px-4">
    @if($company)
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <!-- Header -->
        <div class="bg-gradient-to-r from-indigo-600 to-indigo-800 px-6 py-8">
            <div class="flex items-center">
                @if($company->logo)
                    <img src="{{ Storage::url($company->logo) }}" alt="{{ $company->company_name }}" class="w-24 h-24 rounded-lg object-cover bg-white p-1">
                @else
                    <div class="w-24 h-24 rounded-lg bg-white flex items-center justify-center">
                        <span class="text-3xl font-bold text-indigo-600">{{ substr($company->company_name, 0, 2) }}</span>
                    </div>
                @endif
                <div class="ml-6">
                    <h1 class="text-2xl font-bold text-white">{{ $company->company_name }}</h1>
                    @if($company->tagline)
                        <p class="text-indigo-200 mt-1">{{ $company->tagline }}</p>
                    @endif
                </div>
            </div>
        </div>

        <!-- Actions -->
        <div class="px-6 py-4 bg-gray-50 border-b flex justify-between items-center">
            <div>
                <span class="text-sm text-gray-500">Company Profile</span>
            </div>
            <a href="{{ route('employer.company.edit') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-md hover:bg-indigo-700">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                </svg>
                Edit Profile
            </a>
        </div>

        <!-- Details -->
        <div class="px-6 py-6">
            @if($company->description)
            <div class="mb-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-2">About</h3>
                <p class="text-gray-600">{{ $company->description }}</p>
            </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @if($company->industry)
                <div>
                    <span class="text-sm font-medium text-gray-500">Industry</span>
                    <p class="text-gray-900">{{ $company->industry->name }}</p>
                </div>
                @endif

                @if($company->company_size)
                <div>
                    <span class="text-sm font-medium text-gray-500">Company Size</span>
                    <p class="text-gray-900">{{ $company->company_size }} employees</p>
                </div>
                @endif

                @if($company->founded_year)
                <div>
                    <span class="text-sm font-medium text-gray-500">Founded</span>
                    <p class="text-gray-900">{{ $company->founded_year }}</p>
                </div>
                @endif

                @if($company->website)
                <div>
                    <span class="text-sm font-medium text-gray-500">Website</span>
                    <p><a href="{{ $company->website }}" target="_blank" class="text-indigo-600 hover:underline">{{ $company->website }}</a></p>
                </div>
                @endif

                @if($company->email)
                <div>
                    <span class="text-sm font-medium text-gray-500">Email</span>
                    <p class="text-gray-900">{{ $company->email }}</p>
                </div>
                @endif

                @if($company->phone)
                <div>
                    <span class="text-sm font-medium text-gray-500">Phone</span>
                    <p class="text-gray-900">{{ $company->phone }}</p>
                </div>
                @endif

                @if($company->city || $company->country)
                <div>
                    <span class="text-sm font-medium text-gray-500">Location</span>
                    <p class="text-gray-900">{{ implode(', ', array_filter([$company->city, $company->country])) }}</p>
                </div>
                @endif

                @if($company->address)
                <div>
                    <span class="text-sm font-medium text-gray-500">Address</span>
                    <p class="text-gray-900">{{ $company->address }}</p>
                </div>
                @endif
            </div>
        </div>
    </div>
    @else
    <div class="bg-white rounded-lg shadow-md p-8 text-center">
        <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
        </svg>
        <h2 class="text-xl font-semibold text-gray-900 mb-2">No Company Profile</h2>
        <p class="text-gray-600 mb-6">Create your company profile to start posting jobs.</p>
        <a href="{{ route('employer.company.create') }}" class="inline-flex items-center px-6 py-3 bg-indigo-600 text-white font-medium rounded-md hover:bg-indigo-700">
            Create Company Profile
        </a>
    </div>
    @endif
</div>
@endsection
