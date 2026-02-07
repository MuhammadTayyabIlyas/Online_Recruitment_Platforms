@extends('layouts.admin')

@section('title', 'Add New Partner')

@section('content')
<div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Header -->
    <div class="mb-6">
        <a href="{{ route('admin.authorized-partners.index') }}" class="inline-flex items-center text-indigo-600 hover:text-indigo-900 font-medium mb-4">
            <svg class="h-5 w-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
            Back to Partners
        </a>
        <h1 class="text-2xl font-bold text-gray-900">Designate New Partner</h1>
        <p class="text-sm text-gray-500 mt-1">Select a service user to designate as an authorized partner</p>
    </div>

    @if(session('error'))
        <div class="mb-6 rounded-lg bg-red-50 p-4 border-l-4 border-red-500">
            <span class="text-red-700">{{ session('error') }}</span>
        </div>
    @endif

    <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
        <div class="bg-gradient-to-r from-indigo-50 to-purple-50 px-6 py-4 border-b border-gray-200">
            <h2 class="text-lg font-bold text-gray-900 flex items-center">
                <svg class="w-5 h-5 mr-2 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                </svg>
                Select Service User
            </h2>
        </div>

        <form action="{{ route('admin.authorized-partners.store') }}" method="POST" class="p-6">
            @csrf

            <div class="mb-6">
                <label for="user_id" class="block text-sm font-medium text-gray-700 mb-2">Service User</label>
                @if($serviceUsers->count() > 0)
                    <select name="user_id" id="user_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required>
                        <option value="">-- Select a service user --</option>
                        @foreach($serviceUsers as $user)
                            <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                                {{ $user->name }} ({{ $user->email }})
                            </option>
                        @endforeach
                    </select>
                @else
                    <p class="text-sm text-gray-500 bg-gray-50 rounded-lg p-4">
                        No eligible service users found. All service users already have partner records or no active service users exist.
                    </p>
                @endif

                @error('user_id')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="bg-blue-50 border-l-4 border-blue-400 p-4 mb-6">
                <p class="text-sm text-blue-700">
                    The selected user will be designated as a partner candidate. They will need to complete their business profile before you can approve them.
                </p>
            </div>

            @if($serviceUsers->count() > 0)
                <button type="submit" class="inline-flex items-center px-6 py-3 bg-indigo-600 border border-transparent rounded-md font-semibold text-sm text-white hover:bg-indigo-700 shadow-sm">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    Create Partner Record
                </button>
            @endif
        </form>
    </div>
</div>
@endsection
