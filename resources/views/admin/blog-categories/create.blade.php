@extends('layouts.admin')

@section('title', 'Create Blog Category')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-2xl mx-auto">
        <div class="mb-6">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-800">Create Blog Category</h1>
                    <p class="text-gray-600 mt-1">Add a new category for blog organization</p>
                </div>
                <a href="{{ route('admin.blog-categories.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white rounded-lg transition">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Back
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

        <form action="{{ route('admin.blog-categories.store') }}" method="POST" class="space-y-6">
            @csrf

            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 space-y-6">
                <!-- Name -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1">
                        Category Name <span class="text-red-500">*</span>
                    </label>
                    <input type="text"
                           name="name"
                           id="name"
                           value="{{ old('name') }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('name') border-red-500 @enderror"
                           placeholder="e.g., Study Abroad Guides"
                           required
                           autofocus>
                    @error('name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @else
                        <p class="mt-1 text-xs text-gray-500">Slug will be auto-generated from the name</p>
                    @enderror
                </div>

                <!-- Description -->
                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-1">
                        Description
                    </label>
                    <textarea name="description"
                              id="description"
                              rows="3"
                              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('description') border-red-500 @enderror"
                              placeholder="Brief description of this category">{{ old('description') }}</textarea>
                    @error('description')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @else
                        <p class="mt-1 text-xs text-gray-500">Helps content creators understand what belongs in this category</p>
                    @enderror
                </div>

                <!-- Icon -->
                <div>
                    <label for="icon" class="block text-sm font-medium text-gray-700 mb-1">
                        Icon (Emoji)
                    </label>
                    <input type="text"
                           name="icon"
                           id="icon"
                           value="{{ old('icon') }}"
                           maxlength="2"
                           class="w-20 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-center text-2xl @error('icon') border-red-500 @enderror"
                           placeholder="📚">
                    @error('icon')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @else
                        <p class="mt-1 text-xs text-gray-500">Optional emoji for visual identification</p>
                    @enderror
                    <div class="mt-2 flex flex-wrap gap-2">
                        <button type="button" onclick="document.getElementById('icon').value = '📚'" class="px-3 py-1 bg-gray-100 hover:bg-gray-200 rounded text-xl">📚</button>
                        <button type="button" onclick="document.getElementById('icon').value = '🎓'" class="px-3 py-1 bg-gray-100 hover:bg-gray-200 rounded text-xl">🎓</button>
                        <button type="button" onclick="document.getElementById('icon').value = '💼'" class="px-3 py-1 bg-gray-100 hover:bg-gray-200 rounded text-xl">💼</button>
                        <button type="button" onclick="document.getElementById('icon').value = '✈️'" class="px-3 py-1 bg-gray-100 hover:bg-gray-200 rounded text-xl">✈️</button>
                        <button type="button" onclick="document.getElementById('icon').value = '💰'" class="px-3 py-1 bg-gray-100 hover:bg-gray-200 rounded text-xl">💰</button>
                        <button type="button" onclick="document.getElementById('icon').value = '🌟'" class="px-3 py-1 bg-gray-100 hover:bg-gray-200 rounded text-xl">🌟</button>
                        <button type="button" onclick="document.getElementById('icon').value = '🤖'" class="px-3 py-1 bg-gray-100 hover:bg-gray-200 rounded text-xl">🤖</button>
                        <button type="button" onclick="document.getElementById('icon').value = '🏢'" class="px-3 py-1 bg-gray-100 hover:bg-gray-200 rounded text-xl">🏢</button>
                    </div>
                </div>

                <!-- Sort Order -->
                <div>
                    <label for="sort_order" class="block text-sm font-medium text-gray-700 mb-1">
                        Sort Order
                    </label>
                    <input type="number"
                           name="sort_order"
                           id="sort_order"
                           value="{{ old('sort_order', 0) }}"
                           min="0"
                           class="w-32 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('sort_order') border-red-500 @enderror">
                    @error('sort_order')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @else
                        <p class="mt-1 text-xs text-gray-500">Lower numbers appear first (0 = first position)</p>
                    @enderror
                </div>

                <!-- Active Status -->
                <div>
                    <div class="flex items-center">
                        <input type="checkbox"
                               name="is_active"
                               id="is_active"
                               value="1"
                               {{ old('is_active', true) ? 'checked' : '' }}
                               class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                        <label for="is_active" class="ml-3 text-sm font-medium text-gray-700">
                            Active
                        </label>
                    </div>
                    <p class="mt-1 ml-7 text-xs text-gray-500">Only active categories are visible to content creators</p>
                </div>
            </div>

            <!-- Actions -->
            <div class="flex items-center justify-end space-x-3">
                <a href="{{ route('admin.blog-categories.index') }}"
                   class="px-6 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium rounded-lg transition">
                    Cancel
                </a>
                <button type="submit"
                        class="px-6 py-2 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-medium rounded-lg transition">
                    Create Category
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
