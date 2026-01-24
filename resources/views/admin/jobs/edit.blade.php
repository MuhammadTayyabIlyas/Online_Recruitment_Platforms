@extends('layouts.admin')

@section('title', 'Edit Job')
@section('page-title', 'Edit Job')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="mb-6">
        <a href="{{ route('admin.jobs.index') }}" class="text-indigo-600 hover:text-indigo-900">
            ← Back to Jobs
        </a>
    </div>

    <div class="bg-white shadow rounded-lg">
        <form action="{{ route('admin.jobs.update', $job->id) }}" method="POST" class="p-6 space-y-6">
            @csrf
            @method('PUT')

            <!-- Basic Information -->
            <div>
                <h3 class="text-lg font-medium text-gray-900 mb-4">Basic Information</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="md:col-span-2">
                        <label for="title" class="block text-sm font-medium text-gray-700">Job Title *</label>
                        <input type="text" name="title" id="title" value="{{ old('title', $job->title) }}" required
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        @error('title') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="category_id" class="block text-sm font-medium text-gray-700">Category *</label>
                        <select name="category_id" id="category_id" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id', $job->category_id) == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="location" class="block text-sm font-medium text-gray-700">Location</label>
                        <input type="text" name="location" id="location" value="{{ old('location', $job->location) }}"
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        @error('location') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>
                </div>
            </div>

            <!-- Status and Visibility -->
            <div>
                <h3 class="text-lg font-medium text-gray-900 mb-4">Status & Visibility</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700">Status *</label>
                        <select name="status" id="status" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="draft" {{ old('status', $job->status) === 'draft' ? 'selected' : '' }}>Draft</option>
                            <option value="published" {{ old('status', $job->status) === 'published' ? 'selected' : '' }}>Published</option>
                            <option value="closed" {{ old('status', $job->status) === 'closed' ? 'selected' : '' }}>Closed</option>
                            <option value="expired" {{ old('status', $job->status) === 'expired' ? 'selected' : '' }}>Expired</option>
                        </select>
                        @error('status') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div class="space-y-3 pt-6">
                        <label class="inline-flex items-center">
                            <input type="checkbox" name="is_featured" value="1" {{ old('is_featured', $job->is_featured) ? 'checked' : '' }}
                                   class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <span class="ml-2 text-sm text-gray-700">⭐ Featured Job</span>
                        </label>
                        <br>
                        <label class="inline-flex items-center">
                            <input type="checkbox" name="is_urgent" value="1" {{ old('is_urgent', $job->is_urgent) ? 'checked' : '' }}
                                   class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <span class="ml-2 text-sm text-gray-700">🔥 Urgent Hiring</span>
                        </label>
                        <br>
                        <label class="inline-flex items-center">
                            <input type="checkbox" name="is_remote" value="1" {{ old('is_remote', $job->is_remote) ? 'checked' : '' }}
                                   class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <span class="ml-2 text-sm text-gray-700">🌐 Remote Work</span>
                        </label>
                    </div>
                </div>
            </div>

            <!-- Scheduling -->
            <div>
                <h3 class="text-lg font-medium text-gray-900 mb-4">📅 Scheduling</h3>
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-4">
                    <p class="text-sm text-blue-800">
                        <strong>Scheduling Tips:</strong><br>
                        • <strong>Publish Date:</strong> Set when the job should go live<br>
                        • <strong>Expiry Date:</strong> Set when the job posting should automatically close<br>
                        • Leave blank to publish immediately or never expire
                    </p>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="published_at" class="block text-sm font-medium text-gray-700">Publish Date</label>
                        <input type="datetime-local" name="published_at" id="published_at"
                               value="{{ old('published_at', $job->published_at ? $job->published_at->format('Y-m-d\TH:i') : '') }}"
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        <p class="mt-1 text-xs text-gray-500">When should this job be published?</p>
                        @error('published_at') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="expires_at" class="block text-sm font-medium text-gray-700">Expiry Date</label>
                        <input type="datetime-local" name="expires_at" id="expires_at"
                               value="{{ old('expires_at', $job->expires_at ? $job->expires_at->format('Y-m-d\TH:i') : '') }}"
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        <p class="mt-1 text-xs text-gray-500">When should this job automatically close?</p>
                        @error('expires_at') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>
                </div>
            </div>

            <!-- Current Stats -->
            <div>
                <h3 class="text-lg font-medium text-gray-900 mb-4">📊 Statistics</h3>
                <div class="grid grid-cols-3 gap-4">
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <div class="text-sm text-gray-600">Views</div>
                        <div class="text-2xl font-bold text-gray-900">{{ $job->views_count }}</div>
                    </div>
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <div class="text-sm text-gray-600">Applications</div>
                        <div class="text-2xl font-bold text-gray-900">{{ $job->applications_count }}</div>
                    </div>
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <div class="text-sm text-gray-600">Created</div>
                        <div class="text-sm font-medium text-gray-900">{{ $job->created_at->format('M d, Y') }}</div>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex justify-between items-center border-t pt-6">
                <a href="{{ route('admin.jobs.index') }}" class="text-gray-600 hover:text-gray-900">Cancel</a>
                <div class="space-x-3">
                    @if($job->trashed())
                        <button type="button" onclick="if(confirm('Restore this job?')) { document.getElementById('restoreForm').submit(); }"
                                class="px-6 py-2 bg-green-600 text-white rounded-md hover:bg-green-700">
                            Restore Job
                        </button>
                    @else
                        <button type="submit" class="px-6 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">
                            Update Job
                        </button>
                    @endif
                </div>
            </div>
        </form>

        @if($job->trashed())
            <form id="restoreForm" action="{{ route('admin.jobs.restore', $job->id) }}" method="POST" class="hidden">
                @csrf
            </form>
        @endif
    </div>

    <!-- Quick Actions -->
    <div class="mt-6 bg-white shadow rounded-lg p-6">
        <h3 class="text-lg font-medium text-gray-900 mb-4">Quick Actions</h3>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <form action="{{ route('admin.jobs.update-status', $job->id) }}" method="POST">
                @csrf
                @method('PATCH')
                <input type="hidden" name="status" value="published">
                <button type="submit" class="w-full px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 text-sm">
                    Publish Now
                </button>
            </form>
            <form action="{{ route('admin.jobs.update-status', $job->id) }}" method="POST">
                @csrf
                @method('PATCH')
                <input type="hidden" name="status" value="closed">
                <button type="submit" class="w-full px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 text-sm">
                    Close Job
                </button>
            </form>
            <form action="{{ route('admin.jobs.toggle-featured', $job->id) }}" method="POST">
                @csrf
                @method('PATCH')
                <button type="submit" class="w-full px-4 py-2 bg-yellow-600 text-white rounded-md hover:bg-yellow-700 text-sm">
                    {{ $job->is_featured ? 'Remove Featured' : 'Make Featured' }}
                </button>
            </form>
            <form action="{{ route('admin.jobs.toggle-urgent', $job->id) }}" method="POST">
                @csrf
                @method('PATCH')
                <button type="submit" class="w-full px-4 py-2 bg-orange-600 text-white rounded-md hover:bg-orange-700 text-sm">
                    {{ $job->is_urgent ? 'Remove Urgent' : 'Mark Urgent' }}
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
