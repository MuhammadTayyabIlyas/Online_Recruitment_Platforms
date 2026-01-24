@extends('layouts.admin')

@section('title', 'Settings')
@section('page-title', 'System Settings')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-semibold text-gray-900">Settings</h1>
            <p class="text-gray-600">System configuration and maintenance</p>
        </div>
        <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 text-white rounded-md hover:bg-gray-700">
            Back to Dashboard
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Application Settings -->
        <div class="bg-white shadow rounded-lg p-6">
            <h2 class="text-lg font-semibold text-gray-900 mb-4">Application Settings</h2>
            <dl class="space-y-4">
                <div>
                    <dt class="text-sm font-medium text-gray-500">Application Name</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $settings['app_name'] }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Application URL</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $settings['app_url'] }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Mail From Address</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $settings['mail_from_address'] ?? 'Not configured' }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Mail From Name</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $settings['mail_from_name'] ?? 'Not configured' }}</dd>
                </div>
            </dl>
        </div>

        <!-- System Information -->
        <div class="bg-white shadow rounded-lg p-6">
            <h2 class="text-lg font-semibold text-gray-900 mb-4">System Information</h2>
            <dl class="space-y-4">
                <div>
                    <dt class="text-sm font-medium text-gray-500">PHP Version</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $systemInfo['php_version'] }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Laravel Version</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $systemInfo['laravel_version'] }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Environment</dt>
                    <dd class="mt-1">
                        <span class="px-2 py-1 text-xs font-medium rounded-full {{ $systemInfo['environment'] === 'production' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                            {{ ucfirst($systemInfo['environment']) }}
                        </span>
                    </dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Debug Mode</dt>
                    <dd class="mt-1">
                        <span class="px-2 py-1 text-xs font-medium rounded-full {{ $systemInfo['debug_mode'] === 'Enabled' ? 'bg-red-100 text-red-800' : 'bg-green-100 text-green-800' }}">
                            {{ $systemInfo['debug_mode'] }}
                        </span>
                    </dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Cache Driver</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $systemInfo['cache_driver'] }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Session Driver</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $systemInfo['session_driver'] }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Queue Driver</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $systemInfo['queue_driver'] }}</dd>
                </div>
            </dl>
        </div>

        <!-- Change Password -->
        <div class="bg-white shadow rounded-lg p-6 lg:col-span-2">
            <h2 class="text-lg font-semibold text-gray-900 mb-4">🔐 Change Admin Password</h2>
            <form action="{{ route('admin.settings.change-password') }}" method="POST" class="max-w-xl">
                @csrf
                <div class="space-y-4">
                    <div>
                        <label for="current_password" class="block text-sm font-medium text-gray-700">Current Password *</label>
                        <input type="password" name="current_password" id="current_password" required
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        @error('current_password')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700">New Password *</label>
                        <input type="password" name="password" id="password" required
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        <p class="mt-1 text-xs text-gray-500">Minimum 8 characters</p>
                        @error('password')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirm New Password *</label>
                        <input type="password" name="password_confirmation" id="password_confirmation" required
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        @error('password_confirmation')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="pt-4">
                        <button type="submit" class="inline-flex items-center px-6 py-3 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 font-medium">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                            </svg>
                            Change Password
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <!-- Sitemap Upload -->
        <div class="bg-white shadow rounded-lg p-6 lg:col-span-2">
            <h2 class="text-lg font-semibold text-gray-900 mb-2 flex items-center gap-2">
                <svg class="w-5 h-5 text-indigo-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7h4l3 12 4-16 3 12h4" />
                </svg>
                SEO Sitemap
            </h2>
            <p class="text-sm text-gray-600 mb-4">
                Upload a valid XML sitemap to improve Google visibility. The file will be published at <a class="text-indigo-600 underline" href="{{ url('sitemap.xml') }}" target="_blank" rel="noopener">/sitemap.xml</a>.
            </p>
            <form action="{{ route('admin.settings.sitemap.upload') }}" method="POST" enctype="multipart/form-data" class="flex flex-col md:flex-row md:items-center gap-4">
                @csrf
                <div class="flex-1">
                    <input type="file" name="sitemap" accept=".xml,text/xml" required
                           class="block w-full text-sm text-gray-600 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                    <p class="mt-2 text-xs text-gray-500">Max 5 MB. Google recommends UTF-8 encoded XML.</p>
                </div>
                <div class="flex gap-3">
                    <button type="submit" class="inline-flex items-center px-5 py-2.5 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">
                        <svg class="w-5 h-5 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v2a2 2 0 002 2h12a2 2 0 002-2v-2M7 10l5-5m0 0l5 5m-5-5v12"/>
                        </svg>
                        Upload Sitemap
                    </button>
                    <a href="{{ url('sitemap.xml') }}" target="_blank" rel="noopener" class="inline-flex items-center px-5 py-2.5 border border-gray-200 rounded-md text-gray-700 hover:border-indigo-200 hover:text-indigo-700">
                        View Current
                    </a>
                </div>
            </form>
        </div>

        <!-- Maintenance Actions -->
        <div class="bg-white shadow rounded-lg p-6 lg:col-span-2">
            <h2 class="text-lg font-semibold text-gray-900 mb-4">Maintenance Actions</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <form action="{{ route('admin.settings.clear-cache') }}" method="POST">
                    @csrf
                    <button type="submit" class="w-full flex items-center justify-center px-4 py-3 bg-yellow-100 text-yellow-800 rounded-lg hover:bg-yellow-200">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                        Clear All Caches
                    </button>
                </form>

                <form action="{{ route('admin.settings.optimize') }}" method="POST">
                    @csrf
                    <button type="submit" class="w-full flex items-center justify-center px-4 py-3 bg-green-100 text-green-800 rounded-lg hover:bg-green-200">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                        Optimize Application
                    </button>
                </form>
            </div>
            <p class="mt-4 text-sm text-gray-500">
                <strong>Clear Caches:</strong> Clears all application caches (config, views, routes).
                <br>
                <strong>Optimize:</strong> Caches configuration, routes, and views for better performance.
            </p>
        </div>

        <!-- Quick Stats -->
        <div class="bg-white shadow rounded-lg p-6 lg:col-span-2">
            <h2 class="text-lg font-semibold text-gray-900 mb-4">Database Statistics</h2>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <div class="text-center p-4 bg-gray-50 rounded-lg">
                    <p class="text-2xl font-bold text-indigo-600">{{ \App\Models\User::count() }}</p>
                    <p class="text-sm text-gray-500">Total Users</p>
                </div>
                <div class="text-center p-4 bg-gray-50 rounded-lg">
                    <p class="text-2xl font-bold text-green-600">{{ \App\Models\Job::count() }}</p>
                    <p class="text-sm text-gray-500">Total Jobs</p>
                </div>
                <div class="text-center p-4 bg-gray-50 rounded-lg">
                    <p class="text-2xl font-bold text-yellow-600">{{ \App\Models\Company::count() }}</p>
                    <p class="text-sm text-gray-500">Companies</p>
                </div>
                <div class="text-center p-4 bg-gray-50 rounded-lg">
                    <p class="text-2xl font-bold text-purple-600">{{ \App\Models\JobApplication::count() }}</p>
                    <p class="text-sm text-gray-500">Applications</p>
                </div>
            </div>
        </div>

        <!-- CSV Bulk Import -->
        <div class="bg-white shadow rounded-lg p-6 lg:col-span-2">
            <h2 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                <svg class="w-6 h-6 mr-2 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                </svg>
                CSV Bulk Import
            </h2>
            <p class="text-sm text-gray-600 mb-6">Upload CSV files to bulk import companies and jobs data. Download sample templates to ensure proper formatting.</p>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Companies Import -->
                <div class="border-2 border-dashed border-gray-300 rounded-lg p-6">
                    <h3 class="font-semibold text-gray-900 mb-3 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                        </svg>
                        Import Companies
                    </h3>
                    <p class="text-sm text-gray-600 mb-4">Upload a CSV file containing company information. Employers must exist in the system first.</p>

                    <a href="{{ route('admin.csv.companies-sample') }}" class="inline-flex items-center text-sm text-indigo-600 hover:text-indigo-700 mb-4">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        Download Sample CSV
                    </a>

                    <form action="{{ route('admin.csv.import-companies') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-4">
                            <input type="file" name="csv_file" accept=".csv" required
                                   class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                        </div>
                        <button type="submit" class="w-full inline-flex items-center justify-center px-4 py-2 bg-yellow-600 text-white rounded-md hover:bg-yellow-700">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                            </svg>
                            Upload Companies CSV
                        </button>
                    </form>
                </div>

                <!-- Jobs Import -->
                <div class="border-2 border-dashed border-gray-300 rounded-lg p-6">
                    <h3 class="font-semibold text-gray-900 mb-3 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                        Import Jobs
                    </h3>
                    <p class="text-sm text-gray-600 mb-4">Upload a CSV file containing job listings. Employers and their companies must exist first.</p>

                    <a href="{{ route('admin.csv.jobs-sample') }}" class="inline-flex items-center text-sm text-indigo-600 hover:text-indigo-700 mb-4">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        Download Sample CSV
                    </a>

                    <form action="{{ route('admin.csv.import-jobs') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-4">
                            <input type="file" name="csv_file" accept=".csv" required
                                   class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                        </div>
                        <button type="submit" class="w-full inline-flex items-center justify-center px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                            </svg>
                            Upload Jobs CSV
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- CSV Bulk Export -->
        <div class="bg-white shadow rounded-lg p-6 lg:col-span-2">
            <h2 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                <svg class="w-6 h-6 mr-2 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" transform="rotate(180 12 12)"/>
                </svg>
                CSV Bulk Export
            </h2>
            <p class="text-sm text-gray-600 mb-6">Download all jobs and candidates data as CSV files for backup or analysis.</p>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <a href="{{ route('admin.csv.export-jobs') }}" class="flex items-center justify-center px-6 py-4 bg-gradient-to-r from-green-50 to-green-100 border-2 border-green-200 text-green-800 rounded-lg hover:from-green-100 hover:to-green-200 transition-all">
                    <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                    <div class="text-left">
                        <div class="font-semibold">Export All Jobs</div>
                        <div class="text-sm opacity-75">Download complete jobs database</div>
                    </div>
                </a>

                <a href="{{ route('admin.csv.export-candidates') }}" class="flex items-center justify-center px-6 py-4 bg-gradient-to-r from-blue-50 to-blue-100 border-2 border-blue-200 text-blue-800 rounded-lg hover:from-blue-100 hover:to-blue-200 transition-all">
                    <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                    <div class="text-left">
                        <div class="font-semibold">Export All Candidates</div>
                        <div class="text-sm opacity-75">Download complete candidates database</div>
                    </div>
                </a>
            </div>

            <div class="mt-6 p-4 bg-blue-50 border border-blue-200 rounded-lg">
                <div class="flex">
                    <svg class="w-5 h-5 text-blue-600 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                    </svg>
                    <div class="text-sm text-blue-800">
                        <p class="font-semibold mb-1">Export Information:</p>
                        <ul class="list-disc list-inside space-y-1">
                            <li>Jobs export includes all job listings with company and employer details</li>
                            <li>Candidates export includes job seeker profiles, skills, and education information</li>
                            <li>Large exports may take a moment to process</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
