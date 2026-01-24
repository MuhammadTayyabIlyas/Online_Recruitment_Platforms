@extends('layouts.admin')

@section('title', 'Edit Program')

@section('page-title', 'Edit Program')

@section('content')
<div class="max-w-4xl mx-auto">

    <!-- Back Button -->
    <div class="mb-6">
        <a href="{{ route('admin.programs.index') }}" class="inline-flex items-center text-sm font-medium text-gray-600 hover:text-gray-900">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
            Back to Programs
        </a>
    </div>

    <!-- Validation Errors -->
    @if ($errors->any())
        <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4 rounded">
            <div class="flex items-start">
                <svg class="h-5 w-5 text-red-400 mt-0.5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                </svg>
                <div>
                    <h3 class="text-sm font-medium text-red-800">Please fix the following errors:</h3>
                    <ul class="mt-2 text-sm text-red-700 list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    @endif

    <!-- Edit Form -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100">
        <div class="p-6 border-b border-gray-100">
            <h2 class="text-xl font-bold text-gray-900">Program Information</h2>
            <p class="text-sm text-gray-600 mt-1">Update the program details below</p>
        </div>

        <form method="POST" action="{{ route('admin.programs.update', $program) }}" class="p-6">
            @csrf
            @method('PUT')

            <div class="space-y-6">

                <!-- Basic Information Section -->
                <div class="border-b border-gray-200 pb-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Basic Information</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                        <!-- Program Title -->
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Program Title <span class="text-red-500">*</span>
                            </label>
                            <input
                                type="text"
                                name="title"
                                value="{{ old('title', $program->title) }}"
                                required
                                class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200"
                            >
                            @error('title') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <!-- University -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Educational Institution <span class="text-red-500">*</span>
                            </label>
                            <select
                                name="university_id"
                                required
                                class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200"
                            >
                                <option value="">Select an institution</option>
                                @foreach($universities as $university)
                                    <option value="{{ $university->id }}" {{ old('university_id', $program->university_id) == $university->id ? 'selected' : '' }}>
                                        {{ $university->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('university_id') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <!-- Country -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Country <span class="text-red-500">*</span>
                            </label>
                            <select
                                name="country_id"
                                required
                                class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200"
                            >
                                <option value="">Select a country</option>
                                @foreach($countries as $country)
                                    <option value="{{ $country->id }}" {{ old('country_id', $program->country_id) == $country->id ? 'selected' : '' }}>
                                        {{ $country->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('country_id') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>

                    </div>
                </div>

                <!-- Academic Details Section -->
                <div class="border-b border-gray-200 pb-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Academic Details</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                        <!-- Degree Level -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Degree Level <span class="text-red-500">*</span>
                            </label>
                            <select
                                name="degree_id"
                                required
                                class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200"
                            >
                                <option value="">Select degree</option>
                                @foreach($degrees as $degree)
                                    <option value="{{ $degree->id }}" {{ old('degree_id', $program->degree_id) == $degree->id ? 'selected' : '' }}>
                                        {{ $degree->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('degree_id') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <!-- Subject/Field -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Subject/Field of Study <span class="text-red-500">*</span>
                            </label>
                            <select
                                name="subject_id"
                                required
                                class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200"
                            >
                                <option value="">Select subject</option>
                                @foreach($subjects as $subject)
                                    <option value="{{ $subject->id }}" {{ old('subject_id', $program->subject_id) == $subject->id ? 'selected' : '' }}>
                                        {{ $subject->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('subject_id') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <!-- Language -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Language of Instruction <span class="text-red-500">*</span>
                            </label>
                            <input
                                type="text"
                                name="language"
                                value="{{ old('language', $program->language) }}"
                                required
                                class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200"
                            >
                            @error('language') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <!-- Study Mode -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Study Mode <span class="text-red-500">*</span>
                            </label>
                            <select
                                name="study_mode"
                                required
                                class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200"
                            >
                                @foreach(['On-campus', 'Online', 'Hybrid'] as $mode)
                                    <option value="{{ $mode }}" {{ old('study_mode', $program->study_mode) == $mode ? 'selected' : '' }}>
                                        {{ $mode }}
                                    </option>
                                @endforeach
                            </select>
                            @error('study_mode') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>

                    </div>
                </div>

                <!-- Fees & Admissions Section -->
                <div class="border-b border-gray-200 pb-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Fees & Admissions</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                        <!-- Tuition Fee -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Tuition Fee (EUR/year)
                            </label>
                            <input
                                type="number"
                                name="tuition_fee"
                                value="{{ old('tuition_fee', $program->tuition_fee) }}"
                                min="0"
                                step="100"
                                class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200"
                            >
                            @error('tuition_fee') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <!-- Duration -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Program Duration
                            </label>
                            <input
                                type="text"
                                name="duration"
                                value="{{ old('duration', $program->duration) }}"
                                class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200"
                            >
                            @error('duration') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <!-- Intake -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Next Intake
                            </label>
                            <input
                                type="text"
                                name="intake"
                                value="{{ old('intake', $program->intake) }}"
                                class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200"
                            >
                            @error('intake') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <!-- Application Deadline -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Application Deadline
                            </label>
                            <input
                                type="date"
                                name="application_deadline"
                                value="{{ old('application_deadline', $program->application_deadline ? $program->application_deadline->format('Y-m-d') : '') }}"
                                class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200"
                            >
                            @error('application_deadline') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <!-- Program URL -->
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                External Program URL
                            </label>
                            <input
                                type="url"
                                name="program_url"
                                value="{{ old('program_url', $program->program_url) }}"
                                class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200"
                            >
                            @error('program_url') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>

                    </div>
                </div>

            </div>

            <!-- Action Buttons -->
            <div class="flex items-center justify-between mt-8 pt-6 border-t border-gray-200">
                <a href="{{ route('admin.programs.index') }}" class="px-5 py-2.5 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors font-medium">
                    Cancel
                </a>
                <button type="submit" class="px-6 py-2.5 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors font-medium shadow-sm">
                    Update Program
                </button>
            </div>

        </form>
    </div>

</div>
@endsection
