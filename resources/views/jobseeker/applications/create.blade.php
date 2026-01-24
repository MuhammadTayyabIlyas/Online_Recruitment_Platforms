@extends('layouts.app')

@section('title', 'Apply for ' . $job->title)

@section('content')
<div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
    <!-- Breadcrumb -->
    <nav class="mb-6">
        <ol class="flex items-center space-x-2 text-sm text-gray-500">
            <li><a href="{{ route('jobs.index') }}" class="hover:text-indigo-600">Jobs</a></li>
            <li><span class="mx-2">/</span></li>
            <li><a href="{{ route('jobs.show', $job) }}" class="hover:text-indigo-600">{{ $job->title }}</a></li>
            <li><span class="mx-2">/</span></li>
            <li class="text-gray-900">Apply</li>
        </ol>
    </nav>

    <div class="bg-white shadow rounded-lg overflow-hidden">
        <div class="p-6 border-b border-gray-200">
            <h1 class="text-xl font-bold text-gray-900">Apply for {{ $job->title }}</h1>
            <p class="text-gray-600">{{ $job->company->company_name ?? 'Company' }}</p>
        </div>

        <form action="{{ route('jobseeker.applications.store', $job) }}" method="POST" enctype="multipart/form-data" class="p-6">
            @csrf

            <!-- Cover Letter -->
            <div class="mb-6">
                <label for="cover_letter" class="block text-sm font-medium text-gray-700 mb-2">
                    Cover Letter <span class="text-red-500">*</span>
                </label>
                <textarea name="cover_letter" id="cover_letter" rows="8"
                          class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 @error('cover_letter') border-red-500 @enderror"
                          placeholder="Introduce yourself and explain why you're a great fit for this position..."
                          required>{{ old('cover_letter') }}</textarea>
                <p class="mt-1 text-sm text-gray-500">Minimum 50 characters, maximum 2000 characters</p>
                @error('cover_letter')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Resume Upload -->
            <div class="mb-6">
                <label for="resume" class="block text-sm font-medium text-gray-700 mb-2">
                    Resume <span class="text-red-500">*</span>
                </label>
                <input type="file" name="resume" id="resume"
                       accept=".pdf,.doc,.docx"
                       class="w-full border border-gray-300 rounded-md shadow-sm p-2 @error('resume') border-red-500 @enderror"
                       required>
                <p class="mt-1 text-sm text-gray-500">Accepted formats: PDF, DOC, DOCX. Max size: 2MB</p>
                @error('resume')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Screening Questions -->
            @if($job->questions && $job->questions->count())
                <div class="mb-6">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">Screening Questions</h2>
                    @foreach($job->questions as $index => $question)
                        <div class="mb-4">
                            <label for="answers_{{ $index }}" class="block text-sm font-medium text-gray-700 mb-2">
                                {{ $question->question }}
                                @if($question->is_required)
                                    <span class="text-red-500">*</span>
                                @endif
                            </label>
                            <textarea name="answers[{{ $index }}]" id="answers_{{ $index }}" rows="3"
                                      class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 @error('answers.'.$index) border-red-500 @enderror"
                                      {{ $question->is_required ? 'required' : '' }}>{{ old('answers.'.$index) }}</textarea>
                            @error('answers.'.$index)
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    @endforeach
                </div>
            @endif

            <!-- Submit -->
            <div class="flex items-center justify-between pt-6 border-t border-gray-200">
                <a href="{{ route('jobs.show', $job) }}" class="text-gray-600 hover:text-gray-900">
                    Cancel
                </a>
                <button type="submit"
                        class="px-6 py-3 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 font-medium">
                    Submit Application
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
