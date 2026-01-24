@extends('layouts.admin')

@section('title', 'Edit User')
@section('page-title', 'Edit User')

@section('content')
<div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="mb-6">
        <nav class="flex" aria-label="Breadcrumb">
            <ol class="flex items-center space-x-2 text-sm text-gray-500">
                <li><a href="{{ route('admin.dashboard') }}" class="hover:text-indigo-600">Dashboard</a></li>
                <li><span class="mx-2">/</span></li>
                <li><a href="{{ route('admin.users.index') }}" class="hover:text-indigo-600">Users</a></li>
                <li><span class="mx-2">/</span></li>
                <li class="text-gray-900">Edit {{ $user->name }}</li>
            </ol>
        </nav>
    </div>

    <div class="bg-white shadow rounded-lg">
        <div class="p-6 border-b border-gray-200">
            <div class="flex items-center">
                @if($user->avatar)
                    <img class="h-16 w-16 rounded-full object-cover" src="{{ asset('storage/' . $user->avatar) }}" alt="">
                @else
                    <div class="h-16 w-16 rounded-full bg-gray-200 flex items-center justify-center">
                        <span class="text-2xl font-medium text-gray-500">{{ strtoupper(substr($user->name, 0, 1)) }}</span>
                    </div>
                @endif
                <div class="ml-4">
                    <h1 class="text-xl font-semibold text-gray-900">Edit User</h1>
                    <p class="text-gray-500">{{ $user->email }}</p>
                </div>
            </div>
        </div>

        <form action="{{ route('admin.users.update', $user) }}" method="POST" class="p-6 space-y-6">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Name -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700">Name *</label>
                    <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                    @error('name') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">Email *</label>
                    <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                    @error('email') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

                <!-- User Type -->
                <div>
                    <label for="user_type" class="block text-sm font-medium text-gray-700">User Type *</label>
                    <select name="user_type" id="user_type"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                        <option value="job_seeker" {{ old('user_type', $user->user_type) === 'job_seeker' ? 'selected' : '' }}>Job Seeker</option>
                        <option value="employer" {{ old('user_type', $user->user_type) === 'employer' ? 'selected' : '' }}>Employer</option>
                        <option value="admin" {{ old('user_type', $user->user_type) === 'admin' ? 'selected' : '' }}>Admin</option>
                    </select>
                    @error('user_type') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

                <!-- Status -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">Status</label>
                    <div class="mt-2">
                        <label class="inline-flex items-center">
                            <input type="checkbox" name="is_active" value="1"
                                   {{ old('is_active', $user->is_active) ? 'checked' : '' }}
                                   class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <span class="ml-2 text-sm text-gray-600">Active</span>
                        </label>
                    </div>
                    @if($user->id === auth()->id())
                        <p class="mt-1 text-xs text-yellow-600">You cannot deactivate your own account.</p>
                    @endif
                </div>
            </div>

            <!-- Additional Info -->
            <div class="border-t pt-6">
                <h3 class="text-sm font-medium text-gray-700 mb-4">Account Information</h3>
                <dl class="grid grid-cols-2 gap-4 text-sm">
                    <div>
                        <dt class="font-medium text-gray-500">Created</dt>
                        <dd class="text-gray-900">{{ $user->created_at->format('M d, Y \a\t h:i A') }}</dd>
                    </div>
                    <div>
                        <dt class="font-medium text-gray-500">Last Login</dt>
                        <dd class="text-gray-900">{{ $user->last_login_at ? $user->last_login_at->format('M d, Y \a\t h:i A') : 'Never' }}</dd>
                    </div>
                    <div>
                        <dt class="font-medium text-gray-500">Email Verified</dt>
                        <dd class="text-gray-900">{{ $user->email_verified_at ? $user->email_verified_at->format('M d, Y') : 'Not verified' }}</dd>
                    </div>
                    <div>
                        <dt class="font-medium text-gray-500">Current Roles</dt>
                        <dd class="text-gray-900">{{ $user->roles->pluck('name')->implode(', ') ?: 'None' }}</dd>
                    </div>
                </dl>
            </div>

            <!-- Actions -->
            <div class="flex justify-between items-center border-t pt-6">
                <a href="{{ route('admin.users.index') }}" class="text-gray-600 hover:text-gray-900">Cancel</a>
                <div class="flex space-x-3">
                    @if($user->id !== auth()->id())
                        <button type="button" onclick="document.getElementById('delete-form').submit();"
                                class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700">
                            Delete User
                        </button>
                    @endif
                    <button type="submit" class="px-6 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">
                        Save Changes
                    </button>
                </div>
            </div>
        </form>
    </div>

    @if($user->id !== auth()->id())
    <form id="delete-form" action="{{ route('admin.users.destroy', $user) }}" method="POST" class="hidden"
          onsubmit="return confirm('Are you sure you want to delete this user? This action cannot be undone.');">
        @csrf
        @method('DELETE')
    </form>
    @endif
</div>
@endsection
