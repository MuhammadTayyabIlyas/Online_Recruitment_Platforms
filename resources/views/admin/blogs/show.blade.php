@extends('layouts.admin')

@section('title', 'Review Blog')
@section('page-title', 'Blog Review')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Back Button -->
    <div class="mb-6">
        <a href="{{ route('admin.blogs.index') }}" class="inline-flex items-center text-sm text-gray-600 hover:text-gray-900">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Back to Blogs
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Content (Left Column - 2/3) -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Blog Header -->
            <div class="bg-white rounded-xl shadow-md border border-gray-200 p-6">
                <div class="flex items-start justify-between mb-4">
                    <div class="flex-1">
                        <h1 class="text-3xl font-bold text-gray-900 mb-2">{{ $blog->title }}</h1>
                        <div class="flex items-center gap-4 text-sm text-gray-600">
                            <span class="inline-flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                                {{ $blog->author->name }}
                            </span>
                            <span class="inline-flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                                </svg>
                                {{ $blog->category->name }}
                            </span>
                            <span class="inline-flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                                {{ number_format($blog->views_count) }} views
                            </span>
                            <span>{{ $blog->reading_time }} min read</span>
                        </div>
                    </div>
                    @php
                        $statusColors = [
                            'draft' => 'bg-gray-100 text-gray-800',
                            'pending' => 'bg-yellow-100 text-yellow-800',
                            'approved' => 'bg-green-100 text-green-800',
                            'rejected' => 'bg-red-100 text-red-800',
                        ];
                        $color = $statusColors[$blog->status->value] ?? 'bg-gray-100 text-gray-800';
                    @endphp
                    <span class="px-4 py-2 inline-flex text-sm font-semibold rounded-full {{ $color }}">
                        {{ $blog->status->label() }}
                    </span>
                </div>

                @if($blog->featured_image)
                <div class="mb-6">
                    <img src="{{ asset('storage/' . $blog->featured_image) }}"
                         alt="{{ $blog->featured_image_alt ?? $blog->title }}"
                         class="w-full h-96 object-cover rounded-lg">
                    @if($blog->featured_image_alt)
                        <p class="text-sm text-gray-600 mt-2">Alt text: {{ $blog->featured_image_alt }}</p>
                    @endif
                </div>
                @endif

                @if($blog->excerpt)
                <div class="mb-6 p-4 bg-gray-50 rounded-lg border-l-4 border-indigo-500">
                    <p class="text-gray-700 italic">{{ $blog->excerpt }}</p>
                </div>
                @endif

                <div class="prose prose-lg max-w-none">
                    {!! $blog->content !!}
                </div>
            </div>

            <!-- SEO Information -->
            <div class="bg-white rounded-xl shadow-md border border-gray-200 p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    SEO Information
                </h3>
                <dl class="space-y-3">
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Slug</dt>
                        <dd class="text-sm text-gray-900 font-mono bg-gray-50 p-2 rounded">{{ $blog->slug }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Meta Title ({{ strlen($blog->meta_title ?? $blog->title) }}/60 chars)</dt>
                        <dd class="text-sm text-gray-900">{{ $blog->meta_title ?? $blog->title }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Meta Description ({{ strlen($blog->meta_description ?? $blog->excerpt ?? '') }}/160 chars)</dt>
                        <dd class="text-sm text-gray-900">{{ $blog->meta_description ?? $blog->excerpt ?? 'Not set' }}</dd>
                    </div>
                    @if($blog->meta_keywords)
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Meta Keywords</dt>
                        <dd class="text-sm text-gray-900">{{ $blog->meta_keywords }}</dd>
                    </div>
                    @endif
                </dl>
            </div>
        </div>

        <!-- Sidebar (Right Column - 1/3) -->
        <div class="space-y-6">
            <!-- Admin Actions -->
            <div class="bg-white rounded-xl shadow-md border border-gray-200 p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Admin Actions</h3>

                <div class="space-y-3">
                    <!-- Edit Button -->
                    <a href="{{ route('admin.blogs.edit', $blog) }}"
                       class="w-full inline-flex justify-center items-center px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                        </svg>
                        Edit Blog
                    </a>

                    <!-- Toggle Featured -->
                    <form action="{{ route('admin.blogs.toggle-featured', $blog) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <button type="submit"
                                class="w-full inline-flex justify-center items-center px-4 py-2 {{ $blog->is_featured ? 'bg-gray-200 text-gray-700 hover:bg-gray-300' : 'bg-blue-600 text-white hover:bg-blue-700' }} rounded-md">
                            <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                            </svg>
                            {{ $blog->is_featured ? 'Remove Featured' : 'Mark as Featured' }}
                        </button>
                    </form>

                    @if($blog->status->value === 'approved')
                    <!-- View Public Blog -->
                    <a href="{{ route('blogs.show', $blog->slug) }}" target="_blank"
                       class="w-full inline-flex justify-center items-center px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                        </svg>
                        View Public Page
                    </a>
                    @endif

                    <!-- Delete -->
                    <form action="{{ route('admin.blogs.destroy', $blog) }}" method="POST" onsubmit="return confirm('Move this blog to trash?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                                class="w-full inline-flex justify-center items-center px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                            </svg>
                            Move to Trash
                        </button>
                    </form>
                </div>
            </div>

            <!-- Approval Status Form -->
            @if($blog->status->value !== 'approved')
            <div class="bg-white rounded-xl shadow-md border border-gray-200 p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Review Blog</h3>

                <form action="{{ route('admin.blogs.update-status', $blog) }}" method="POST" class="space-y-4">
                    @csrf
                    @method('PATCH')

                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                        <select name="status" id="status" required
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="approved" {{ $blog->status->value === 'approved' ? 'selected' : '' }}>Approve</option>
                            <option value="rejected" {{ $blog->status->value === 'rejected' ? 'selected' : '' }}>Reject</option>
                            <option value="pending" {{ $blog->status->value === 'pending' ? 'selected' : '' }}>Keep Pending</option>
                            <option value="draft" {{ $blog->status->value === 'draft' ? 'selected' : '' }}>Revert to Draft</option>
                        </select>
                    </div>

                    <div>
                        <label for="admin_feedback" class="block text-sm font-medium text-gray-700 mb-2">
                            Admin Feedback
                            <span class="text-xs text-gray-500">(visible to author)</span>
                        </label>
                        <textarea name="admin_feedback" id="admin_feedback" rows="4"
                                  class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                  placeholder="Provide feedback to the author...">{{ old('admin_feedback', $blog->admin_feedback) }}</textarea>
                        <p class="mt-1 text-xs text-gray-500">This feedback will be sent to the author via email notification.</p>
                    </div>

                    <button type="submit"
                            class="w-full inline-flex justify-center items-center px-4 py-3 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 font-medium">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        Update Status
                    </button>
                </form>
            </div>
            @endif

            <!-- Blog Details -->
            <div class="bg-white rounded-xl shadow-md border border-gray-200 p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Blog Details</h3>
                <dl class="space-y-3">
                    <div>
                        <dt class="text-xs font-medium text-gray-500 uppercase">Author</dt>
                        <dd class="text-sm text-gray-900 mt-1">
                            <div class="flex items-center">
                                <div>
                                    <div class="font-medium">{{ $blog->author->name }}</div>
                                    <div class="text-xs text-gray-500">{{ $blog->author->email }}</div>
                                    <div class="text-xs text-gray-500">{{ ucfirst(str_replace('_', ' ', $blog->author->user_type)) }}</div>
                                </div>
                            </div>
                        </dd>
                    </div>

                    <div class="border-t pt-3">
                        <dt class="text-xs font-medium text-gray-500 uppercase">Created</dt>
                        <dd class="text-sm text-gray-900 mt-1">{{ $blog->created_at->format('F d, Y \a\t h:i A') }}</dd>
                    </div>

                    @if($blog->submitted_at)
                    <div>
                        <dt class="text-xs font-medium text-gray-500 uppercase">Submitted</dt>
                        <dd class="text-sm text-gray-900 mt-1">{{ $blog->submitted_at->format('F d, Y \a\t h:i A') }}</dd>
                    </div>
                    @endif

                    @if($blog->reviewed_at)
                    <div>
                        <dt class="text-xs font-medium text-gray-500 uppercase">Reviewed</dt>
                        <dd class="text-sm text-gray-900 mt-1">
                            {{ $blog->reviewed_at->format('F d, Y \a\t h:i A') }}
                            @if($blog->reviewer)
                                <div class="text-xs text-gray-500">by {{ $blog->reviewer->name }}</div>
                            @endif
                        </dd>
                    </div>
                    @endif

                    @if($blog->published_at)
                    <div>
                        <dt class="text-xs font-medium text-gray-500 uppercase">Published</dt>
                        <dd class="text-sm text-gray-900 mt-1">{{ $blog->published_at->format('F d, Y \a\t h:i A') }}</dd>
                    </div>
                    @endif

                    <div class="border-t pt-3">
                        <dt class="text-xs font-medium text-gray-500 uppercase">Last Updated</dt>
                        <dd class="text-sm text-gray-900 mt-1">{{ $blog->updated_at->format('F d, Y \a\t h:i A') }}</dd>
                    </div>
                </dl>
            </div>

            <!-- Current Admin Feedback (if exists) -->
            @if($blog->admin_feedback && $blog->status->value === 'rejected')
            <div class="bg-red-50 border border-red-200 rounded-xl p-6">
                <h3 class="text-sm font-semibold text-red-900 mb-2 flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                    Current Rejection Feedback
                </h3>
                <p class="text-sm text-red-800">{{ $blog->admin_feedback }}</p>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
