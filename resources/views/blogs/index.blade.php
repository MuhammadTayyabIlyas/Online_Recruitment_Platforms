@extends('layouts.app')

@section('title', 'Blog - Latest Insights & Guides')

@section('content')
<!-- Hero Section -->
<div class="bg-gradient-to-r from-blue-600 to-purple-600 text-white py-16">
    <div class="container mx-auto px-4">
        <div class="max-w-3xl mx-auto text-center">
            <h1 class="text-5xl font-bold mb-4">Blog & Insights</h1>
            <p class="text-xl text-blue-100 mb-8">Expert guidance on studying abroad, scholarships, admissions, and career success</p>

            <!-- Search Form -->
            <form action="{{ route('blogs.index') }}" method="GET" class="relative max-w-2xl mx-auto">
                <input type="text"
                       name="search"
                       value="{{ request('search') }}"
                       placeholder="Search articles..."
                       class="w-full px-6 py-4 rounded-full text-gray-900 placeholder-gray-500 focus:outline-none focus:ring-4 focus:ring-blue-300">
                <button type="submit"
                        class="absolute right-2 top-1/2 -translate-y-1/2 px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-full transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </button>
            </form>
        </div>
    </div>
</div>

<div class="container mx-auto px-4 py-12">
    <div class="flex flex-wrap lg:flex-nowrap gap-8">
        <!-- Main Content -->
        <div class="w-full lg:w-3/4">
            <!-- Featured Blogs -->
            @if($featuredBlogs->count() > 0 && !request()->has('search') && !request()->has('category'))
                <div class="mb-12">
                    <h2 class="text-3xl font-bold text-gray-900 mb-6 flex items-center">
                        <svg class="w-8 h-8 mr-3 text-yellow-500" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                        </svg>
                        Featured Articles
                    </h2>

                    <div class="grid grid-cols-1 md:grid-cols-{{ min(3, $featuredBlogs->count()) }} gap-6">
                        @foreach($featuredBlogs as $blog)
                            <a href="{{ route('blogs.show', $blog->slug) }}" class="group">
                                <div class="bg-white rounded-lg shadow-md hover:shadow-xl transition overflow-hidden h-full flex flex-col">
                                    @if($blog->featured_image)
                                        <div class="relative overflow-hidden h-48">
                                            <img src="{{ Storage::url($blog->featured_image) }}"
                                                 alt="{{ $blog->featured_image_alt }}"
                                                 class="w-full h-full object-cover group-hover:scale-110 transition duration-300">
                                            <div class="absolute top-4 left-4">
                                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-yellow-400 text-yellow-900">
                                                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                                    </svg>
                                                    Featured
                                                </span>
                                            </div>
                                        </div>
                                    @endif

                                    <div class="p-6 flex-1 flex flex-col">
                                        <div class="mb-3">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                {{ $blog->category->icon }} {{ $blog->category->name }}
                                            </span>
                                        </div>

                                        <h3 class="text-xl font-bold text-gray-900 mb-2 group-hover:text-blue-600 transition">
                                            {{ $blog->title }}
                                        </h3>

                                        <p class="text-gray-600 mb-4 flex-1">
                                            {{ Str::limit($blog->excerpt, 120) }}
                                        </p>

                                        <div class="flex items-center text-sm text-gray-500">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                            </svg>
                                            <span>{{ $blog->published_at->format('M d, Y') }}</span>
                                            <span class="mx-2">•</span>
                                            <span>{{ $blog->reading_time }} min read</span>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Filter Bar -->
            <div class="mb-8 flex flex-wrap items-center justify-between gap-4">
                <div>
                    <h2 class="text-2xl font-bold text-gray-900">
                        @if(request()->has('category'))
                            {{ $selectedCategory->name }}
                        @elseif(request()->has('search'))
                            Search Results
                        @else
                            Latest Articles
                        @endif
                    </h2>
                    <p class="text-gray-600 mt-1">{{ $blogs->total() }} {{ Str::plural('article', $blogs->total()) }} found</p>
                </div>

                <div class="flex items-center gap-3">
                    <label for="sort" class="text-sm text-gray-600">Sort by:</label>
                    <select name="sort"
                            id="sort"
                            onchange="window.location.href='{{ route('blogs.index') }}?' + new URLSearchParams({...Object.fromEntries(new URLSearchParams(window.location.search)), sort: this.value})"
                            class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="latest" {{ request('sort', 'latest') == 'latest' ? 'selected' : '' }}>Latest</option>
                        <option value="popular" {{ request('sort') == 'popular' ? 'selected' : '' }}>Most Popular</option>
                        <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Oldest</option>
                    </select>
                </div>
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
                    <p class="mt-2 text-gray-600">Try adjusting your search or filter to find what you're looking for.</p>
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
                           class="flex items-center justify-between px-3 py-2 rounded-lg transition {{ !request()->has('category') ? 'bg-blue-50 text-blue-700 font-medium' : 'text-gray-700 hover:bg-gray-50' }}">
                            <span>All Articles</span>
                            <span class="text-sm">{{ $totalBlogs }}</span>
                        </a>
                    </li>
                    @foreach($categories as $category)
                        <li>
                            <a href="{{ route('blogs.category', $category->slug) }}"
                               class="flex items-center justify-between px-3 py-2 rounded-lg transition {{ request('category') == $category->id ? 'bg-blue-50 text-blue-700 font-medium' : 'text-gray-700 hover:bg-gray-50' }}">
                                <span>{{ $category->icon }} {{ $category->name }}</span>
                                <span class="text-sm">{{ $category->blogs_count }}</span>
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>

            <!-- Popular Posts -->
            @if($popularBlogs->count() > 0)
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h3 class="text-xl font-bold text-gray-900 mb-4">Popular Articles</h3>

                    <ul class="space-y-4">
                        @foreach($popularBlogs as $blog)
                            <li>
                                <a href="{{ route('blogs.show', $blog->slug) }}" class="group flex gap-3">
                                    @if($blog->featured_image)
                                        <img src="{{ Storage::url($blog->featured_image) }}"
                                             alt="{{ $blog->featured_image_alt }}"
                                             class="w-20 h-20 object-cover rounded-lg flex-shrink-0">
                                    @endif
                                    <div class="flex-1">
                                        <h4 class="text-sm font-medium text-gray-900 group-hover:text-blue-600 transition line-clamp-2">
                                            {{ $blog->title }}
                                        </h4>
                                        <div class="flex items-center mt-2 text-xs text-gray-500">
                                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                            </svg>
                                            <span>{{ number_format($blog->views_count) }} views</span>
                                        </div>
                                    </div>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </aside>
    </div>
</div>
@endsection
