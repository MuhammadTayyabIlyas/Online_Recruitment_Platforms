@extends('layouts.employer')

@section('title', 'Post a New Job')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="mb-6">
        <h1 class="text-2xl font-semibold text-gray-900">Post a New Job</h1>
        <p class="text-gray-600">Fill in the details below to create a new job posting.</p>
    </div>

    @php
        $activeSubscription = auth()->user()->activeSubscription;
        $jobsCount = \App\Models\Job::where('company_id', auth()->user()->company->id)->count();
        $hasFreeTier = !$activeSubscription && $jobsCount === 0;
    @endphp

    @if($hasFreeTier)
        <div class="mb-6 bg-blue-50 border border-blue-200 rounded-md p-4">
            <div class="flex items-center">
                <svg class="w-5 h-5 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                </svg>
                <div class="ml-3">
                    <p class="text-sm text-blue-700">
                        <strong>Free Job Posting:</strong> You are using your <strong>1 free job posting</strong>. 
                        No subscription required!
                    </p>
                </div>
            </div>
        </div>
    @endif

    <form action="{{ route('employer.jobs.store') }}" method="POST" class="bg-white shadow rounded-lg">
        @csrf

        <!-- Basic Information -->
        <div class="p-6 border-b border-gray-200">
            <h2 class="text-lg font-semibold text-gray-900 mb-4">Basic Information</h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Job Title -->
                <div class="md:col-span-2">
                    <label for="title" class="block text-sm font-medium text-gray-700 mb-1">
                        Job Title <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="title" id="title" value="{{ old('title') }}"
                           class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 @error('title') border-red-500 @enderror"
                           placeholder="e.g. Senior Software Engineer" required>
                    @error('title')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Category -->
                <div>
                    <label for="category_id" class="block text-sm font-medium text-gray-700 mb-1">
                        Category <span class="text-red-500">*</span>
                    </label>
                    <select name="category_id" id="category_id"
                            class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 @error('category_id') border-red-500 @enderror"
                            required>
                        <option value="">Select Category</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Job Type -->
                <div>
                    <label for="job_type_id" class="block text-sm font-medium text-gray-700 mb-1">
                        Job Type <span class="text-red-500">*</span>
                    </label>
                    <select name="job_type_id" id="job_type_id"
                            class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 @error('job_type_id') border-red-500 @enderror"
                            required>
                        <option value="">Select Job Type</option>
                        @foreach($jobTypes as $jobType)
                            <option value="{{ $jobType->id }}" {{ old('job_type_id') == $jobType->id ? 'selected' : '' }}>
                                {{ $jobType->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('job_type_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Employment Type -->
                <div>
                    <label for="employment_type_id" class="block text-sm font-medium text-gray-700 mb-1">
                        Employment Type
                    </label>
                    <select name="employment_type_id" id="employment_type_id"
                            class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 @error('employment_type_id') border-red-500 @enderror">
                        <option value="">Select Employment Type</option>
                        @foreach($employmentTypes as $employmentType)
                            <option value="{{ $employmentType->id }}" {{ old('employment_type_id') == $employmentType->id ? 'selected' : '' }}>
                                {{ $employmentType->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('employment_type_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Location -->
                <div>
                    <label for="location" class="block text-sm font-medium text-gray-700 mb-1">
                        Location <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="location" id="location" value="{{ old('location') }}"
                           class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 @error('location') border-red-500 @enderror"
                           placeholder="e.g. New York, NY" required>
                    @error('location')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Remote Option -->
                <div class="md:col-span-2">
                    <label class="inline-flex items-center">
                        <input type="checkbox" name="is_remote" value="1" {{ old('is_remote') ? 'checked' : '' }}
                               class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                        <span class="ml-2 text-sm text-gray-700">This is a remote position</span>
                    </label>
                </div>
            </div>
        </div>

        <!-- Job Details -->
        <div class="p-6 border-b border-gray-200">
            <h2 class="text-lg font-semibold text-gray-900 mb-4">Job Details</h2>

            <!-- Description -->
            <div class="mb-6">
                <label for="description" class="block text-sm font-medium text-gray-700 mb-1">
                    Job Description <span class="text-red-500">*</span>
                </label>
                <textarea name="description" id="description" rows="6"
                          class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 @error('description') border-red-500 @enderror"
                          placeholder="Describe the role, responsibilities, and what makes this opportunity exciting..."
                          required>{{ old('description') }}</textarea>
                <p class="mt-1 text-sm text-gray-500">Minimum 50 characters</p>
                @error('description')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Requirements -->
            <div class="mb-6">
                <label for="requirements" class="block text-sm font-medium text-gray-700 mb-1">
                    Requirements
                </label>
                <textarea name="requirements" id="requirements" rows="4"
                          class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 @error('requirements') border-red-500 @enderror"
                          placeholder="List the skills, experience, and qualifications required...">{{ old('requirements') }}</textarea>
                @error('requirements')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Benefits -->
            <div>
                <label for="benefits" class="block text-sm font-medium text-gray-700 mb-1">
                    Benefits
                </label>
                <textarea name="benefits" id="benefits" rows="4"
                          class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 @error('benefits') border-red-500 @enderror"
                          placeholder="Describe the benefits and perks of this position...">{{ old('benefits') }}</textarea>
                @error('benefits')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <!-- Compensation -->
        <div class="p-6 border-b border-gray-200">
            <h2 class="text-lg font-semibold text-gray-900 mb-4">Compensation</h2>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Salary Min -->
                <div>
                    <label for="min_salary" class="block text-sm font-medium text-gray-700 mb-1">
                        Minimum Salary
                    </label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-500">$</span>
                        <input type="number" name="min_salary" id="min_salary" value="{{ old('min_salary') }}"
                               class="w-full pl-8 border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 @error('min_salary') border-red-500 @enderror"
                               placeholder="50000" min="0">
                    </div>
                    @error('min_salary')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Salary Max -->
                <div>
                    <label for="max_salary" class="block text-sm font-medium text-gray-700 mb-1">
                        Maximum Salary
                    </label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-500">$</span>
                        <input type="number" name="max_salary" id="max_salary" value="{{ old('max_salary') }}"
                               class="w-full pl-8 border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 @error('max_salary') border-red-500 @enderror"
                               placeholder="80000" min="0">
                    </div>
                    @error('max_salary')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Hide Salary -->
                <div class="flex items-end">
                    <label class="inline-flex items-center">
                        <input type="checkbox" name="hide_salary" value="1" {{ old('hide_salary') ? 'checked' : '' }}
                               class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                        <span class="ml-2 text-sm text-gray-700">Hide salary on listing</span>
                    </label>
                </div>
            </div>
        </div>

        <!-- Skills -->
        <div class="p-6 border-b border-gray-200">
            <h2 class="text-lg font-semibold text-gray-900 mb-4">Required Skills</h2>

            <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                @foreach($skills as $skill)
                    <label class="inline-flex items-center">
                        <input type="checkbox" name="skills[]" value="{{ $skill->id }}"
                               {{ in_array($skill->id, old('skills', [])) ? 'checked' : '' }}
                               class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                        <span class="ml-2 text-sm text-gray-700">{{ $skill->name }}</span>
                    </label>
                @endforeach
            </div>
            @error('skills')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Application Settings -->
        <div class="p-6 border-b border-gray-200">
            <h2 class="text-lg font-semibold text-gray-900 mb-4">Application Settings</h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Deadline -->
                <div>
                    <label for="expires_at" class="block text-sm font-medium text-gray-700 mb-1">
                        Application Deadline
                    </label>
                    <input type="date" name="expires_at" id="expires_at" value="{{ old('expires_at') }}"
                           class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 @error('expires_at') border-red-500 @enderror"
                           min="{{ date('Y-m-d', strtotime('+1 day')) }}">
                    <p class="mt-1 text-sm text-gray-500">Leave empty for no deadline</p>
                    @error('expires_at')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Featured -->
                <div class="flex items-end">
                    <label class="inline-flex items-center">
                        <input type="checkbox" name="is_featured" value="1" {{ old('is_featured') ? 'checked' : '' }}
                               class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                        <span class="ml-2 text-sm text-gray-700">Feature this job (additional cost may apply)</span>
                    </label>
                </div>
            </div>
        </div>

        <!-- Submit -->
        <div class="p-6 bg-gray-50 flex items-center justify-between">
            <a href="{{ route('employer.jobs.index') }}" class="text-gray-600 hover:text-gray-900">
                Cancel
            </a>
            <button type="submit"
                    class="px-6 py-3 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 font-medium">
                Post Job
            </button>
        </div>
    </form>
</div>
@endsection
