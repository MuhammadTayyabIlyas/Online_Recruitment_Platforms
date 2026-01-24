@extends('layouts.app')

@section('title', 'Edit Job Alert')

@section('content')
<div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="mb-6">
        <h1 class="text-2xl font-semibold text-gray-900">Edit Job Alert</h1>
        <p class="text-gray-600">Update the criteria for this alert</p>
    </div>

    <form action="{{ route('jobseeker.alerts.update', $alert) }}" method="POST" class="bg-white shadow rounded-lg p-6 space-y-6">
        @csrf
        @method('PUT')

        <!-- Alert Name -->
        <div>
            <label for="name" class="block text-sm font-medium text-gray-700">Alert Name *</label>
            <input type="text" name="name" id="name" value="{{ old('name', $alert->name) }}"
                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                   placeholder="e.g., Senior Developer Jobs" required>
            @error('name') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>

        <!-- Keywords -->
        <div>
            <label for="keywords" class="block text-sm font-medium text-gray-700">Keywords</label>
            <input type="text" name="keywords" id="keywords" value="{{ old('keywords', $alert->keywords) }}"
                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                   placeholder="e.g., React, Node.js, Remote">
            <p class="mt-1 text-xs text-gray-500">Separate multiple keywords with commas</p>
            @error('keywords') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>

        <!-- Location -->
        <div>
            <label for="location" class="block text-sm font-medium text-gray-700">Location</label>
            <input type="text" name="location" id="location" value="{{ old('location', $alert->location) }}"
                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                   placeholder="e.g., New York, Remote">
            @error('location') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>

        <!-- Category -->
        <div>
            <label for="category_id" class="block text-sm font-medium text-gray-700">Category</label>
            <select name="category_id" id="category_id"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                <option value="">All Categories</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ old('category_id', $alert->category_id) == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
            @error('category_id') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>

        <!-- Job Type -->
        <div>
            <label for="job_type_id" class="block text-sm font-medium text-gray-700">Job Type</label>
            <select name="job_type_id" id="job_type_id"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                <option value="">All Job Types</option>
                @foreach($jobTypes as $jobType)
                    <option value="{{ $jobType->id }}" {{ old('job_type_id', $alert->job_type_id) == $jobType->id ? 'selected' : '' }}>
                        {{ $jobType->name }}
                    </option>
                @endforeach
            </select>
            @error('job_type_id') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>

        <!-- Employment Type -->
        <div>
            <label for="employment_type_id" class="block text-sm font-medium text-gray-700">Employment Type</label>
            <select name="employment_type_id" id="employment_type_id"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                <option value="">All Employment Types</option>
                @foreach($employmentTypes as $employmentType)
                    <option value="{{ $employmentType->id }}" {{ old('employment_type_id', $alert->employment_type_id) == $employmentType->id ? 'selected' : '' }}>
                        {{ $employmentType->name }}
                    </option>
                @endforeach
            </select>
            @error('employment_type_id') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>

        <!-- Minimum Salary -->
        <div>
            <label for="min_salary" class="block text-sm font-medium text-gray-700">Minimum Salary</label>
            <div class="mt-1 relative">
                <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-500">$</span>
                <input type="number" name="min_salary" id="min_salary" value="{{ old('min_salary', $alert->min_salary) }}"
                       class="block w-full pl-8 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                       placeholder="0" min="0">
            </div>
            @error('min_salary') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>

        <!-- Frequency -->
        <div>
            <label for="frequency" class="block text-sm font-medium text-gray-700">Email Frequency *</label>
            <select name="frequency" id="frequency"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                <option value="daily" {{ old('frequency', $alert->frequency) == 'daily' ? 'selected' : '' }}>Daily</option>
                <option value="weekly" {{ old('frequency', $alert->frequency) == 'weekly' ? 'selected' : '' }}>Weekly</option>
            </select>
            @error('frequency') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>

        <!-- Active -->
        <div class="flex items-center">
            <label class="inline-flex items-center">
                <input type="checkbox" name="is_active" value="1" {{ old('is_active', $alert->is_active) ? 'checked' : '' }}
                       class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                <span class="ml-2 text-sm text-gray-700">Send me emails for this alert</span>
            </label>
        </div>

        <!-- Actions -->
        <div class="flex justify-between items-center pt-4 border-t">
            <a href="{{ route('jobseeker.alerts.index') }}" class="text-gray-600 hover:text-gray-900">Cancel</a>
            <button type="submit"
                    class="px-6 py-3 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 font-medium">
                Save Changes
            </button>
        </div>
    </form>
</div>
@endsection
