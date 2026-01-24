@extends('layouts.app')

@section('title', $category->name . ' - Blog')

@section('content')
<!-- Hero Section -->
<div class="bg-gradient-to-r from-blue-600 to-purple-600 text-white py-16">
    <div class="container mx-auto px-4">
        <div class="max-w-3xl mx-auto text-center">
            <div class="mb-4">
                <span class="text-6xl">{{ $category->icon }}</span>
            </div>
            <h1 class="text-5xl font-bold mb-4">{{ $category->name }}</h1>
            <p class="text-xl text-blue-100">{{ $category->description }}</p>
        </div>
    </div>
</div>

<div class="container mx-auto px-4 py-12">
    <div class="flex flex-wrap lg:flex-nowrap gap-8">
        <!-- Main Content -->
        <div class="w-full lg:w-3/4">
            <div class="mb-8">
                <h2 class="text-2xl font-bold text-gray-900">
                    {{ $category->name }}
                </h2>
                <p class="text-gray-600 mt-1">{{ $blogs->total() }} {{ Str::plural('article', $blogs->total()) }} found</p>
            </div>

            <!-- Blog Grid -->
            @if($blogs->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-12">
                    @foreach($blogs as $blog)
                        <article class="bg-white rounded-lg shadow-md hover:shadow-xl transition overflow-hidden group">
                            <a href="{{ route('blogs.show', $blog->slug) }}" class="block">
                                @if($blog->featured_image)
                                    <div class="relative overflow-hidden h-56">
                                        <img src="{{ Storage::url($blog->featured_image) }}"
                                             alt="{{ $blog->featured_image_alt }}"
                                             class="w-full h-full object-cover group-hover:scale-110 transition duration-300">
                                    </div>
                                @endif

                                <div class="p-6">
                                    <div class="mb-3 flex items-center justify-between">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                            {{ $blog->category->icon }} {{ $blog->category->name }}
                                        </span>
                                        @if($blog->is_featured)
                                            <span class="text-yellow-500">
                                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                                </svg>
                                            </span>
                                        @endif
                                    </div>

                                    <h2 class="text-2xl font-bold text-gray-900 mb-3 group-hover:text-blue-600 transition">
                                        {{ $blog->title }}
                                    </h2>

                                    <p class="text-gray-600 mb-4">
                                        {{ Str::limit($blog->excerpt, 150) }}
                                    </p>

                                    <div class="flex items-center justify-between text-sm text-gray-500">
                                        <div class="flex items-center">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                            </svg>
                                            <span>{{ $blog->published_at->format('M d, Y') }}</span>
                                        </div>

                                        <div class="flex items-center gap-4">
                                            <div class="flex items-center">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                                </svg>
                                                <span>{{ number_format($blog->views_count) }}</span>
                                            </div>

                                            <div class="flex items-center">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                </svg>
                                                <span>{{ $blog->reading_time }} min</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </article>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="mt-8">
                    {{ $blogs->links() }}
                </div>
            @else
                <div class="text-center py-16">
                    <svg class="mx-auto h-16 w-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    <h3 class="mt-4 text-2xl font-medium text-gray-900">No articles found</h3>
                    <p class="mt-2 text-gray-600">There are no articles in this category yet.</p>
                    <div class="mt-6">
                        <a href="{{ route('blogs.index') }}" class="inline-flex items-center px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                            </svg>
                            View All Articles
                        </a>
                    </div>
                </div>
            @endif
        </div>

        <!-- Sidebar -->
        <aside class="w-full lg:w-1/4">
            <!-- Categories -->
            <div class="bg-white rounded-lg shadow-md p-6 mb-8 sticky top-4">
                <h3 class="text-xl font-bold text-gray-900 mb-4">Categories</h3>

                <ul class="space-y-2">
                    <li>
                        <a href="{{ route('blogs.index') }}"
                           class="flex items-center justify-between px-3 py-2 rounded-lg transition text-gray-700 hover:bg-gray-50">
                            <span>All Articles</span>
                        </a>
                    </li>
                    @foreach($categories as $cat)
                        <li>
                            <a href="{{ route('blogs.category', $cat->slug) }}"
                               class="flex items-center justify-between px-3 py-2 rounded-lg transition {{ $cat->id == $category->id ? 'bg-blue-50 text-blue-700 font-medium' : 'text-gray-700 hover:bg-gray-50' }}">
                                <span>{{ $cat->icon }} {{ $cat->name }}</span>
                                <span class="text-sm">{{ $cat->blogs_count }}</span>
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </aside>
    </div>
</div>
@endsection
