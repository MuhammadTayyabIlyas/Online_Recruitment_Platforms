@extends('layouts.employer')

@section('title', 'Edit Job: ' . $job->title)

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="mb-6">
        <nav class="mb-4">
            <ol class="flex items-center space-x-2 text-sm text-gray-500">
                <li><a href="{{ route('employer.jobs.index') }}" class="hover:text-indigo-600">Jobs</a></li>
                <li><span class="mx-2">/</span></li>
                <li><a href="{{ route('employer.jobs.show', $job) }}" class="hover:text-indigo-600">{{ $job->title }}</a></li>
                <li><span class="mx-2">/</span></li>
                <li class="text-gray-900">Edit</li>
            </ol>
        </nav>
        <h1 class="text-2xl font-semibold text-gray-900">Edit Job</h1>
    </div>

    <form action="{{ route('employer.jobs.update', $job) }}" method="POST" class="bg-white shadow rounded-lg">
        @csrf
        @method('PUT')

        <!-- Basic Information -->
        <div class="p-6 border-b border-gray-200">
            <h2 class="text-lg font-semibold text-gray-900 mb-4">Basic Information</h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Job Title -->
                <div class="md:col-span-2">
                    <label for="title" class="block text-sm font-medium text-gray-700 mb-1">
                        Job Title <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="title" id="title" value="{{ old('title', $job->title) }}"
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
                            <option value="{{ $category->id }}" {{ old('category_id', $job->category_id) == $category->id ? 'selected' : '' }}>
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
                            <option value="{{ $jobType->id }}" {{ old('job_type_id', $job->job_type_id) == $jobType->id ? 'selected' : '' }}>
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
                            <option value="{{ $employmentType->id }}" {{ old('employment_type_id', $job->employment_type_id) == $employmentType->id ? 'selected' : '' }}>
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
                    <input type="text" name="location" id="location" value="{{ old('location', $job->location) }}"
                           class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 @error('location') border-red-500 @enderror"
                           placeholder="e.g. New York, NY" required>
                    @error('location')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Remote Option -->
                <div class="md:col-span-2">
                    <label class="inline-flex items-center">
                        <input type="checkbox" name="is_remote" value="1" {{ old('is_remote', $job->is_remote) ? 'checked' : '' }}
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
                          required>{{ old('description', $job->description) }}</textarea>
                <p class="mt-1 text-sm text-gray-500">Minimum 100 characters</p>
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
                          placeholder="List the skills, experience, and qualifications required...">{{ old('requirements', $job->requirements) }}</textarea>
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
                          placeholder="Describe the benefits and perks of this position...">{{ old('benefits', $job->benefits) }}</textarea>
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
                        <input type="number" name="min_salary" id="min_salary" value="{{ old('min_salary', $job->min_salary) }}"
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
                        <input type="number" name="max_salary" id="max_salary" value="{{ old('max_salary', $job->max_salary) }}"
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
                        <input type="checkbox" name="hide_salary" value="1" {{ old('hide_salary', $job->hide_salary) ? 'checked' : '' }}
                               class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                        <span class="ml-2 text-sm text-gray-700">Hide salary on listing</span>
                    </label>
                </div>
            </div>
        </div>

        <!-- Skills -->
        <div class="p-6 border-b border-gray-200">
            <h2 class="text-lg font-semibold text-gray-900 mb-4">Required Skills</h2>

            @php
                $selectedSkills = old('skills', $job->skills->pluck('id')->toArray());
            @endphp

            <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                @foreach($skills as $skill)
                    <label class="inline-flex items-center">
                        <input type="checkbox" name="skills[]" value="{{ $skill->id }}"
                               {{ in_array($skill->id, $selectedSkills) ? 'checked' : '' }}
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
                    <input type="date" name="expires_at" id="expires_at"
                           value="{{ old('expires_at', $job->expires_at ? $job->expires_at->format('Y-m-d') : '') }}"
                           class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 @error('expires_at') border-red-500 @enderror"
                           min="{{ date('Y-m-d', strtotime('+1 day')) }}">
                    <p class="mt-1 text-sm text-gray-500">Leave empty for no deadline</p>
                    @error('expires_at')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Submit -->
        <div class="p-6 bg-gray-50 flex items-center justify-between">
            <a href="{{ route('employer.jobs.show', $job) }}" class="text-gray-600 hover:text-gray-900">
                Cancel
            </a>
            <button type="submit"
                    class="px-6 py-3 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 font-medium">
                Update Job
            </button>
        </div>
    </form>
</div>
@endsection
