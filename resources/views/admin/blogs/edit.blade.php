@extends('layouts.admin')

@section('title', 'Edit Blog')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="mb-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-800">Edit Blog</h1>
                <p class="text-gray-600 mt-1">Update blog post details</p>
            </div>
            <a href="{{ route('admin.blogs.show', $blog) }}" class="inline-flex items-center px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white rounded-lg transition">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Back to Review
            </a>
        </div>
    </div>

    @if($errors->any())
        <div class="mb-6 bg-red-50 border border-red-200 rounded-lg p-4">
            <div class="flex items-start">
                <svg class="w-5 h-5 text-red-600 mt-0.5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                </svg>
                <div class="flex-1">
                    <h3 class="text-red-800 font-semibold">There were some errors with your submission</h3>
                    <ul class="mt-2 text-sm text-red-700 list-disc list-inside">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    @endif

    <form action="{{ route('admin.blogs.update', $blog) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Main Content -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Basic Information -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <h2 class="text-xl font-bold text-gray-800 mb-4">Basic Information</h2>

                    <div class="space-y-4">
                        <div>
                            <label for="title" class="block text-sm font-medium text-gray-700 mb-1">
                                Blog Title <span class="text-red-500">*</span>
                            </label>
                            <input type="text"
                                   name="title"
                                   id="title"
                                   value="{{ old('title', $blog->title) }}"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('title') border-red-500 @enderror"
                                   required>
                            @error('title')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="blog_category_id" class="block text-sm font-medium text-gray-700 mb-1">
                                Category <span class="text-red-500">*</span>
                            </label>
                            <select name="blog_category_id"
                                    id="blog_category_id"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('blog_category_id') border-red-500 @enderror"
                                    required>
                                <option value="">Select a category</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}"
                                            {{ old('blog_category_id', $blog->blog_category_id) == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('blog_category_id')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="excerpt" class="block text-sm font-medium text-gray-700 mb-1">
                                Excerpt
                                <span class="text-gray-500 text-xs">(Optional - Auto-generated if empty)</span>
                            </label>
                            <textarea name="excerpt"
                                      id="excerpt"
                                      rows="3"
                                      maxlength="500"
                                      class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('excerpt') border-red-500 @enderror"
                                      placeholder="Brief summary of the blog post (max 500 characters)">{{ old('excerpt', $blog->excerpt) }}</textarea>
                            <div class="flex justify-between mt-1">
                                @error('excerpt')
                                    <p class="text-sm text-red-600">{{ $message }}</p>
                                @else
                                    <p class="text-sm text-gray-500">Brief summary for preview cards</p>
                                @enderror
                                <p class="text-sm text-gray-500"><span id="excerptCount">{{ strlen(old('excerpt', $blog->excerpt ?? '')) }}</span>/500</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Featured Image -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <h2 class="text-xl font-bold text-gray-800 mb-4">Featured Image</h2>

                    <div class="space-y-4">
                        @if($blog->featured_image)
                            <div>
                                <p class="text-sm font-medium text-gray-700 mb-2">Current Image</p>
                                <img src="{{ Storage::url($blog->featured_image) }}"
                                     alt="{{ $blog->featured_image_alt }}"
                                     class="w-full h-48 object-cover rounded-lg border border-gray-300">
                            </div>
                        @endif

                        <div>
                            <label for="featured_image" class="block text-sm font-medium text-gray-700 mb-1">
                                {{ $blog->featured_image ? 'Replace Featured Image' : 'Featured Image' }}
                                @if(!$blog->featured_image)
                                    <span class="text-red-500">*</span>
                                @endif
                            </label>
                            <input type="file"
                                   name="featured_image"
                                   id="featured_image"
                                   accept="image/jpeg,image/png,image/jpg,image/webp"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('featured_image') border-red-500 @enderror"
                                   {{ $blog->featured_image ? '' : 'required' }}>
                            <p class="mt-1 text-xs text-gray-500">
                                Recommended: 1920x1080px (16:9 ratio) • Max 5MB • JPG, PNG, WEBP
                            </p>
                            @error('featured_image')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="featured_image_alt" class="block text-sm font-medium text-gray-700 mb-1">
                                Image Alt Text <span class="text-red-500">*</span>
                            </label>
                            <input type="text"
                                   name="featured_image_alt"
                                   id="featured_image_alt"
                                   value="{{ old('featured_image_alt', $blog->featured_image_alt) }}"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('featured_image_alt') border-red-500 @enderror"
                                   placeholder="Describe the image for SEO and accessibility"
                                   required>
                            @error('featured_image_alt')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Content -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <h2 class="text-xl font-bold text-gray-800 mb-4">Content</h2>

                    <div>
                        <label for="content" class="block text-sm font-medium text-gray-700 mb-1">
                            Blog Content <span class="text-red-500">*</span>
                        </label>
                        <input id="content" type="hidden" name="content" value="{{ old('content', $blog->content) }}">
                        <trix-editor input="content"
                                     class="trix-content border border-gray-300 rounded-lg @error('content') border-red-500 @enderror"></trix-editor>
                        @error('content')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- SEO Settings -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="text-xl font-bold text-gray-800">SEO Settings</h2>
                        <button type="button"
                                onclick="document.getElementById('seoFields').classList.toggle('hidden')"
                                class="text-sm text-blue-600 hover:text-blue-700">
                            Toggle
                        </button>
                    </div>

                    <div id="seoFields" class="space-y-4">
                        <div>
                            <label for="meta_title" class="block text-sm font-medium text-gray-700 mb-1">
                                Meta Title
                                <span class="text-gray-500 text-xs">(Optional - Uses blog title if empty)</span>
                            </label>
                            <input type="text"
                                   name="meta_title"
                                   id="meta_title"
                                   value="{{ old('meta_title', $blog->meta_title) }}"
                                   maxlength="60"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                   placeholder="Custom title for search engines">
                            <div class="flex justify-between mt-1">
                                <p class="text-xs text-gray-500">Optimal: 50-60 characters</p>
                                <p class="text-xs text-gray-500"><span id="metaTitleCount">{{ strlen(old('meta_title', $blog->meta_title ?? '')) }}</span>/60</p>
                            </div>
                        </div>

                        <div>
                            <label for="meta_description" class="block text-sm font-medium text-gray-700 mb-1">
                                Meta Description
                                <span class="text-gray-500 text-xs">(Optional - Uses excerpt if empty)</span>
                            </label>
                            <textarea name="meta_description"
                                      id="meta_description"
                                      rows="3"
                                      maxlength="160"
                                      class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                      placeholder="Brief description for search results">{{ old('meta_description', $blog->meta_description) }}</textarea>
                            <div class="flex justify-between mt-1">
                                <p class="text-xs text-gray-500">Optimal: 150-160 characters</p>
                                <p class="text-xs text-gray-500"><span id="metaDescCount">{{ strlen(old('meta_description', $blog->meta_description ?? '')) }}</span>/160</p>
                            </div>
                        </div>

                        <div>
                            <label for="meta_keywords" class="block text-sm font-medium text-gray-700 mb-1">
                                Meta Keywords
                                <span class="text-gray-500 text-xs">(Optional)</span>
                            </label>
                            <input type="text"
                                   name="meta_keywords"
                                   id="meta_keywords"
                                   value="{{ old('meta_keywords', $blog->meta_keywords) }}"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                   placeholder="keyword1, keyword2, keyword3">
                            <p class="mt-1 text-xs text-gray-500">Comma-separated keywords</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="lg:col-span-1 space-y-6">
                <!-- Blog Status -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <h3 class="text-lg font-bold text-gray-800 mb-4">Blog Status</h3>

                    <div class="space-y-3">
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-600">Current Status:</span>
                            {!! $blog->status->badge() !!}
                        </div>

                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-600">Author:</span>
                            <span class="text-sm font-medium text-gray-900">{{ $blog->author->name }}</span>
                        </div>

                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-600">Views:</span>
                            <span class="text-sm font-medium text-gray-900">{{ number_format($blog->views_count) }}</span>
                        </div>

                        @if($blog->published_at)
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-gray-600">Published:</span>
                                <span class="text-sm font-medium text-gray-900">{{ $blog->published_at->format('M d, Y') }}</span>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Featured Settings -->
                <div class="bg-gradient-to-br from-purple-50 to-pink-50 rounded-lg shadow-sm border border-purple-200 p-6">
                    <h3 class="text-lg font-bold text-gray-800 mb-4">Featured Settings</h3>

                    <div class="space-y-4">
                        <div class="flex items-center">
                            <input type="checkbox"
                                   name="is_featured"
                                   id="is_featured"
                                   value="1"
                                   {{ old('is_featured', $blog->is_featured) ? 'checked' : '' }}
                                   class="w-4 h-4 text-purple-600 border-gray-300 rounded focus:ring-purple-500">
                            <label for="is_featured" class="ml-3 text-sm font-medium text-gray-700">
                                Mark as Featured
                            </label>
                        </div>

                        <div>
                            <label for="featured_order" class="block text-sm font-medium text-gray-700 mb-1">
                                Featured Order
                            </label>
                            <input type="number"
                                   name="featured_order"
                                   id="featured_order"
                                   value="{{ old('featured_order', $blog->featured_order ?? 0) }}"
                                   min="0"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                            <p class="mt-1 text-xs text-gray-500">Lower numbers appear first</p>
                        </div>
                    </div>
                </div>

                <!-- Actions -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <h3 class="text-lg font-bold text-gray-800 mb-4">Actions</h3>

                    <div class="space-y-3">
                        <button type="submit"
                                class="w-full inline-flex justify-center items-center px-4 py-2 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-medium rounded-lg transition">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            Update Blog
                        </button>

                        <a href="{{ route('admin.blogs.show', $blog) }}"
                           class="w-full inline-flex justify-center items-center px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium rounded-lg transition">
                            Cancel
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

@push('styles')
<link rel="stylesheet" href="https://unpkg.com/trix@2.0.8/dist/trix.css">
<style>
    trix-toolbar .trix-button-group--file-tools { display: none; }
    trix-editor {
        min-height: 400px;
        max-height: 600px;
        overflow-y: auto;
    }
    .trix-content {
        background: white;
    }
</style>
@endpush

@push('scripts')
<script src="https://unpkg.com/trix@2.0.8/dist/trix.umd.min.js"></script>
<script>
    // Character counters
    document.getElementById('excerpt')?.addEventListener('input', function() {
        document.getElementById('excerptCount').textContent = this.value.length;
    });

    document.getElementById('meta_title')?.addEventListener('input', function() {
        document.getElementById('metaTitleCount').textContent = this.value.length;
    });

    document.getElementById('meta_description')?.addEventListener('input', function() {
        document.getElementById('metaDescCount').textContent = this.value.length;
    });

    // Trix editor image upload handler
    document.addEventListener('trix-attachment-add', function(event) {
        const attachment = event.attachment;
        if (attachment.file) {
            uploadAttachment(attachment);
        }
    });

    function uploadAttachment(attachment) {
        const formData = new FormData();
        formData.append('attachment', attachment.file);
        formData.append('_token', '{{ csrf_token() }}');

        fetch('{{ route("content-creator.blogs.upload-attachment") }}', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.url) {
                attachment.setAttributes({
                    url: data.url,
                    href: data.url
                });
            }
        })
        .catch(error => {
            console.error('Upload failed:', error);
        });
    }
</script>
@endpush
@endsection
