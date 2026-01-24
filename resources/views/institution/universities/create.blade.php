@extends('layouts.employer')

@section('title', 'Add Educational Institution')

@section('content')
<div class="max-w-3xl mx-auto py-6 px-4">
    <h1 class="text-2xl font-bold text-gray-900 mb-2">Add Educational Institution</h1>
    <p class="text-sm text-gray-600 mb-6">Create an institution so it appears in the program dropdown.</p>

    @if(session('status'))
        <div class="mb-4 rounded border border-green-200 bg-green-50 px-4 py-3 text-green-700">
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('institution.universities.store') }}" class="space-y-4 bg-white shadow-sm rounded-lg p-6">
        @csrf
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Institution Name *</label>
            <input type="text" name="name" value="{{ old('name') }}" required class="w-full rounded-md border-gray-300 focus:border-blue-500 focus:ring-blue-500">
            @error('name')<p class="text-sm text-red-600">{{ $message }}</p>@enderror
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Country *</label>
            @if($countries->count() > 0)
                <select name="country_id" class="w-full rounded-md border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                    <option value="">Select Country</option>
                    @foreach($countries as $country)
                        <option value="{{ $country->id }}" @selected(old('country_id') == $country->id)>{{ $country->name }}</option>
                    @endforeach
                </select>
                @error('country_id')<p class="text-sm text-red-600">{{ $message }}</p>@enderror
            @else
                <input type="text" name="country_name" value="{{ old('country_name') }}" required class="w-full rounded-md border-gray-300 focus:border-blue-500 focus:ring-blue-500" placeholder="Enter country name">
                @error('country_name')<p class="text-sm text-red-600">{{ $message }}</p>@enderror
                <p class="text-xs text-gray-500 mt-1">Countries are not seeded. Enter the country name and we’ll add it.</p>
            @endif
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Website</label>
            <input type="url" name="website" value="{{ old('website') }}" class="w-full rounded-md border-gray-300 focus:border-blue-500 focus:ring-blue-500" placeholder="https://">
            @error('website')<p class="text-sm text-red-600">{{ $message }}</p>@enderror
        </div>
        <div class="flex justify-end gap-3">
            <a href="{{ url()->previous() }}" class="px-4 py-2 rounded-md bg-gray-100 text-gray-700">Cancel</a>
            <button type="submit" class="px-4 py-2 rounded-md bg-blue-600 text-white hover:bg-blue-700">Save Institution</button>
        </div>
    </form>
</div>
@endsection
