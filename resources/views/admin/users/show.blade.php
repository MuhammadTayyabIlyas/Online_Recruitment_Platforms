@extends('layouts.admin')

@section('title', 'User Details')
@section('page-title', 'User Details')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="mb-6">
        <nav class="flex" aria-label="Breadcrumb">
            <ol class="flex items-center space-x-2 text-sm text-gray-500">
                <li><a href="{{ route('admin.dashboard') }}" class="hover:text-indigo-600">Dashboard</a></li>
                <li><span class="mx-2">/</span></li>
                <li><a href="{{ route('admin.users.index') }}" class="hover:text-indigo-600">Users</a></li>
                <li><span class="mx-2">/</span></li>
                <li class="text-gray-900">{{ $user->name }}</li>
            </ol>
        </nav>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- User Info Card -->
        <div class="lg:col-span-1">
            <div class="bg-white shadow rounded-lg p-6">
                <div class="text-center">
                    @if($user->avatar)
                        <img class="h-24 w-24 rounded-full mx-auto object-cover" src="{{ asset('storage/' . $user->avatar) }}" alt="">
                    @else
                        <div class="h-24 w-24 rounded-full bg-gray-200 flex items-center justify-center mx-auto">
                            <span class="text-3xl font-medium text-gray-500">{{ strtoupper(substr($user->name, 0, 1)) }}</span>
                        </div>
                    @endif
                    <h2 class="mt-4 text-xl font-semibold text-gray-900">{{ $user->name }}</h2>
                    <p class="text-gray-500">{{ $user->email }}</p>
                    <span class="mt-2 px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full
                        {{ $user->user_type === 'admin' ? 'bg-red-100 text-red-800' : '' }}
                        {{ $user->user_type === 'employer' ? 'bg-blue-100 text-blue-800' : '' }}
                        {{ $user->user_type === 'job_seeker' ? 'bg-green-100 text-green-800' : '' }}">
                        {{ ucfirst(str_replace('_', ' ', $user->user_type)) }}
                    </span>
                </div>

                <div class="mt-6 border-t pt-6">
                    <dl class="space-y-4">
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Status</dt>
                            <dd class="mt-1">
                                @if($user->is_active)
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Active</span>
                                @else
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Inactive</span>
                                @endif
                            </dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Phone</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $user->phone ?? 'Not provided' }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Joined</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $user->created_at->format('M d, Y \a\t h:i A') }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Last Login</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $user->last_login_at ? $user->last_login_at->diffForHumans() : 'Never' }}</dd>
                        </div>
                    </dl>
                </div>

                <div class="mt-6 flex space-x-3">
                    <a href="{{ route('admin.users.edit', $user) }}"
                       class="flex-1 text-center px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">
                        Edit User
                    </a>
                    @if($user->id !== auth()->id())
                        <form action="{{ route('admin.users.toggle-status', $user) }}" method="POST" class="flex-1">
                            @csrf
                            @method('PATCH')
                            <button type="submit"
                                    class="w-full px-4 py-2 {{ $user->is_active ? 'bg-yellow-600 hover:bg-yellow-700' : 'bg-green-600 hover:bg-green-700' }} text-white rounded-md">
                                {{ $user->is_active ? 'Deactivate' : 'Activate' }}
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        </div>

        <!-- Details Section -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Profile Info -->
            @if($user->profile)
            <div class="bg-white shadow rounded-lg p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Profile Information</h3>
                <dl class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @if($user->profile->headline)
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Headline</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $user->profile->headline }}</dd>
                    </div>
                    @endif
                    @if($user->profile->current_job_title)
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Current Job Title</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $user->profile->current_job_title }}</dd>
                    </div>
                    @endif
                    @if($user->profile->location)
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Location</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $user->profile->location }}</dd>
                    </div>
                    @endif
                    @if($user->profile->city || $user->profile->country)
                    <div>
                        <dt class="text-sm font-medium text-gray-500">City / Country</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ collect([$user->profile->city, $user->profile->country])->filter()->implode(', ') }}</dd>
                    </div>
                    @endif
                    @if($user->profile->nationality)
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Nationality</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $user->profile->nationality }}</dd>
                    </div>
                    @endif
                    @if($user->profile->gender)
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Gender</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ ucfirst($user->profile->gender) }}</dd>
                    </div>
                    @endif
                    @if($user->profile->date_of_birth)
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Date of Birth</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $user->profile->date_of_birth->format('M d, Y') }} ({{ $user->profile->age }} years old)</dd>
                    </div>
                    @endif
                    @if($user->profile->address)
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Address</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $user->profile->address }}</dd>
                    </div>
                    @endif
                    @if($user->profile->postal_code)
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Postal Code</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $user->profile->postal_code }}</dd>
                    </div>
                    @endif
                    @if($user->profile->passport_number)
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Passport Number</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $user->profile->passport_number }}</dd>
                    </div>
                    @endif
                    @if($user->profile->website)
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Website</dt>
                        <dd class="mt-1 text-sm"><a href="{{ $user->profile->website }}" target="_blank" class="text-indigo-600 hover:text-indigo-800">{{ $user->profile->website }}</a></dd>
                    </div>
                    @endif
                    @if($user->profile->linkedin_url)
                    <div>
                        <dt class="text-sm font-medium text-gray-500">LinkedIn</dt>
                        <dd class="mt-1 text-sm"><a href="{{ $user->profile->linkedin_url }}" target="_blank" class="text-indigo-600 hover:text-indigo-800">{{ $user->profile->linkedin_url }}</a></dd>
                    </div>
                    @endif
                    @if($user->profile->github_url)
                    <div>
                        <dt class="text-sm font-medium text-gray-500">GitHub</dt>
                        <dd class="mt-1 text-sm"><a href="{{ $user->profile->github_url }}" target="_blank" class="text-indigo-600 hover:text-indigo-800">{{ $user->profile->github_url }}</a></dd>
                    </div>
                    @endif
                    @if($user->profile->bio)
                    <div class="md:col-span-2">
                        <dt class="text-sm font-medium text-gray-500">Bio</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $user->profile->bio }}</dd>
                    </div>
                    @endif
                </dl>
            </div>
            @endif

            <!-- Company (for employers) -->
            @if($user->user_type === 'employer' && $user->company)
            <div class="bg-white shadow rounded-lg p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Company Information</h3>
                <div class="flex items-center mb-4">
                    @if($user->company->logo)
                        <img src="{{ asset('storage/' . $user->company->logo) }}" alt="{{ $user->company->company_name }}"
                             class="w-16 h-16 rounded-lg object-cover mr-4">
                    @endif
                    <div>
                        <h4 class="font-medium text-gray-900">{{ $user->company->company_name }}</h4>
                        <p class="text-sm text-gray-500">{{ $user->company->industry ?? 'Industry not specified' }}</p>
                    </div>
                </div>
                <dl class="grid grid-cols-2 gap-4 text-sm mb-4">
                    <div>
                        <dt class="font-medium text-gray-500">Jobs Posted</dt>
                        <dd class="text-gray-900">{{ $user->jobs->count() }}</dd>
                    </div>
                    <div>
                        <dt class="font-medium text-gray-500">Company Size</dt>
                        <dd class="text-gray-900">{{ $user->company->company_size ?? 'Not specified' }}</dd>
                    </div>
                    <div class="col-span-2">
                        <dt class="font-medium text-gray-500">CV/Profile Access</dt>
                        <dd class="mt-1">
                            @if($user->company->is_cv_access_approved)
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                                    Approved
                                </span>
                            @else
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/></svg>
                                    Not Approved
                                </span>
                            @endif
                        </dd>
                    </div>
                </dl>

                <!-- CV Access Toggle Button -->
                <form action="{{ route('admin.users.toggle-cv-access', $user) }}" method="POST" class="mt-4">
                    @csrf
                    @method('PATCH')
                    <button type="submit"
                            class="w-full px-4 py-2 {{ $user->company->is_cv_access_approved ? 'bg-red-600 hover:bg-red-700' : 'bg-green-600 hover:bg-green-700' }} text-white rounded-md transition-colors flex items-center justify-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            @if($user->company->is_cv_access_approved)
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            @else
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            @endif
                        </svg>
                        {{ $user->company->is_cv_access_approved ? 'Revoke CV Access' : 'Grant CV Access' }}
                    </button>
                </form>

                <!-- Package Assignment Section -->
                <div class="mt-6 border-t pt-6">
                    <h4 class="text-sm font-semibold text-gray-900 mb-4">Package Management</h4>

                    @php
                        $currentSubscription = $user->activeSubscription;
                        $allPackages = App\Models\Package::where('is_active', true)->orderBy('price')->get();
                    @endphp

                    @if($currentSubscription)
                        <div class="mb-4 p-3 bg-blue-50 rounded-lg">
                            <p class="text-sm font-medium text-blue-900">Current Package</p>
                            <p class="text-xs text-blue-700 mt-1">
                                {{ $currentSubscription->package->name }} -
                                Expires: {{ $currentSubscription->expires_at->format('M d, Y') }}
                            </p>
                        </div>
                    @else
                        <div class="mb-4 p-3 bg-gray-50 rounded-lg">
                            <p class="text-sm font-medium text-gray-900">No Active Package</p>
                            <p class="text-xs text-gray-600 mt-1">User is on free tier</p>
                        </div>
                    @endif

                    <form action="{{ route('admin.users.assign-package', $user) }}" method="POST">
                        @csrf
                        <div class="space-y-2">
                            <label class="block text-xs font-medium text-gray-700">Assign New Package</label>
                            <select name="package_id" class="w-full border-gray-300 rounded-md text-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="">-- Select Package --</option>
                                @foreach($allPackages as $package)
                                    <option value="{{ $package->id }}">
                                        {{ $package->name }} - &euro;{{ number_format($package->price, 0) }}/month
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <button type="submit"
                                class="w-full mt-3 px-4 py-2 bg-purple-600 text-white text-sm rounded-md hover:bg-purple-700 transition-colors flex items-center justify-center">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                            </svg>
                            Assign Package
                        </button>
                    </form>
                </div>
            </div>
            @endif

            <!-- Education Section -->
            @if($user->user_type === 'job_seeker')
            <div class="bg-white shadow rounded-lg p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Education</h3>
                @if($user->education->count() > 0)
                    <div class="space-y-4">
                        @foreach($user->education as $edu)
                        <div class="border-b pb-4 last:border-b-0 last:pb-0">
                            <div class="flex justify-between items-start">
                                <div>
                                    <h4 class="font-medium text-gray-900">{{ $edu->degree }}{{ $edu->field_of_study ? ' in ' . $edu->field_of_study : '' }}</h4>
                                    <p class="text-sm text-gray-600">{{ $edu->institution }}</p>
                                </div>
                                <span class="text-sm text-gray-500 whitespace-nowrap ml-4">{{ $edu->start_date }} - {{ $edu->is_current ? 'Present' : $edu->end_date }}</span>
                            </div>
                            @if($edu->grade)
                                <p class="text-sm text-gray-500 mt-1">Grade: {{ $edu->grade }}</p>
                            @endif
                            @if($edu->description)
                                <p class="text-sm text-gray-600 mt-2">{{ $edu->description }}</p>
                            @endif
                        </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-sm text-gray-500">No education records added yet.</p>
                @endif
            </div>
            @endif

            <!-- Work Experience Section -->
            @if($user->user_type === 'job_seeker')
            <div class="bg-white shadow rounded-lg p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Work Experience</h3>
                @if($user->experience->count() > 0)
                    <div class="space-y-4">
                        @foreach($user->experience as $exp)
                        <div class="border-b pb-4 last:border-b-0 last:pb-0">
                            <div class="flex justify-between items-start">
                                <div>
                                    <h4 class="font-medium text-gray-900">{{ $exp->job_title }}</h4>
                                    <p class="text-sm text-gray-600">{{ $exp->company_name }}{{ $exp->location ? ' - ' . $exp->location : '' }}</p>
                                </div>
                                <div class="text-right ml-4">
                                    <span class="text-sm text-gray-500 whitespace-nowrap">{{ $exp->start_date->format('M Y') }} - {{ $exp->is_current ? 'Present' : $exp->end_date->format('M Y') }}</span>
                                    @if($exp->employment_type)
                                        <span class="block mt-1 px-2 py-0.5 text-xs font-medium rounded-full bg-blue-100 text-blue-800 inline-flex">{{ $exp->formattedEmploymentType }}</span>
                                    @endif
                                </div>
                            </div>
                            @if($exp->description)
                                <p class="text-sm text-gray-600 mt-2">{{ $exp->description }}</p>
                            @endif
                        </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-sm text-gray-500">No work experience added yet.</p>
                @endif
            </div>
            @endif

            <!-- Skills Section -->
            @if($user->user_type === 'job_seeker')
            <div class="bg-white shadow rounded-lg p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Skills</h3>
                @if($user->skills->count() > 0)
                    <div class="flex flex-wrap gap-2">
                        @foreach($user->skills as $skill)
                            @php
                                $levelColors = [
                                    'beginner' => 'bg-gray-100 text-gray-800',
                                    'intermediate' => 'bg-blue-100 text-blue-800',
                                    'advanced' => 'bg-indigo-100 text-indigo-800',
                                    'expert' => 'bg-purple-100 text-purple-800',
                                ];
                                $color = $levelColors[$skill->proficiency_level] ?? 'bg-gray-100 text-gray-800';
                            @endphp
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $color }}">
                                {{ $skill->formattedSkillName }}
                                @if($skill->proficiency_level)
                                    <span class="ml-1 text-xs opacity-75">({{ ucfirst($skill->proficiency_level) }})</span>
                                @endif
                                @if($skill->years_of_experience)
                                    <span class="ml-1 text-xs opacity-75">{{ $skill->years_of_experience }}y</span>
                                @endif
                            </span>
                        @endforeach
                    </div>
                @else
                    <p class="text-sm text-gray-500">No skills added yet.</p>
                @endif
            </div>
            @endif

            <!-- Languages Section -->
            @if($user->user_type === 'job_seeker')
            <div class="bg-white shadow rounded-lg p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Languages</h3>
                @if($user->languages->count() > 0)
                    <div class="flex flex-wrap gap-2">
                        @foreach($user->languages as $lang)
                            @php
                                $profColors = [
                                    'basic' => 'bg-gray-100 text-gray-800',
                                    'conversational' => 'bg-green-100 text-green-800',
                                    'fluent' => 'bg-blue-100 text-blue-800',
                                    'native' => 'bg-indigo-100 text-indigo-800',
                                ];
                                $color = $profColors[$lang->proficiency] ?? 'bg-gray-100 text-gray-800';
                            @endphp
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $color }}">
                                {{ $lang->language }}
                                @if($lang->proficiency)
                                    <span class="ml-1 text-xs opacity-75">({{ $lang->formattedProficiency }})</span>
                                @endif
                            </span>
                        @endforeach
                    </div>
                @else
                    <p class="text-sm text-gray-500">No languages added yet.</p>
                @endif
            </div>
            @endif

            <!-- Certifications Section -->
            @if($user->user_type === 'job_seeker')
            <div class="bg-white shadow rounded-lg p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Certifications</h3>
                @if($user->certifications->count() > 0)
                    <div class="space-y-4">
                        @foreach($user->certifications as $cert)
                        <div class="border-b pb-4 last:border-b-0 last:pb-0">
                            <div class="flex justify-between items-start">
                                <div>
                                    <h4 class="font-medium text-gray-900">{{ $cert->name }}</h4>
                                    @if($cert->issuing_organization)
                                        <p class="text-sm text-gray-600">{{ $cert->issuing_organization }}</p>
                                    @endif
                                </div>
                                <div class="ml-4">
                                    @if($cert->expiry_date)
                                        @if($cert->isExpired())
                                            <span class="px-2 py-0.5 text-xs font-medium rounded-full bg-red-100 text-red-800">Expired</span>
                                        @else
                                            <span class="px-2 py-0.5 text-xs font-medium rounded-full bg-green-100 text-green-800">Valid</span>
                                        @endif
                                    @endif
                                </div>
                            </div>
                            <div class="mt-1 text-sm text-gray-500">
                                @if($cert->issue_date)
                                    Issued: {{ $cert->issue_date->format('M Y') }}
                                @endif
                                @if($cert->expiry_date)
                                    &middot; Expires: {{ $cert->expiry_date->format('M Y') }}
                                @endif
                            </div>
                            @if($cert->credential_id)
                                <p class="text-sm text-gray-500 mt-1">Credential ID: {{ $cert->credential_id }}</p>
                            @endif
                            @if($cert->credential_url)
                                <a href="{{ $cert->credential_url }}" target="_blank" class="text-sm text-indigo-600 hover:text-indigo-800 mt-1 inline-block">View Credential</a>
                            @endif
                        </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-sm text-gray-500">No certifications added yet.</p>
                @endif
            </div>
            @endif

            <!-- Resumes / CVs Section -->
            @if($user->user_type === 'job_seeker')
            <div class="bg-white shadow rounded-lg p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Resumes / CVs</h3>
                @if($user->resumes->count() > 0)
                    <div class="space-y-3">
                        @foreach($user->resumes as $resume)
                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                            <div class="flex items-center min-w-0">
                                <svg class="w-8 h-8 text-red-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z" clip-rule="evenodd"/>
                                </svg>
                                <div class="ml-3 min-w-0">
                                    <p class="text-sm font-medium text-gray-900 truncate">
                                        {{ $resume->title ?? $resume->file_name }}
                                        @if($resume->is_primary)
                                            <span class="ml-1 px-2 py-0.5 text-xs font-medium rounded-full bg-indigo-100 text-indigo-800">Primary</span>
                                        @endif
                                    </p>
                                    <p class="text-xs text-gray-500">{{ $resume->file_name }} &middot; {{ $resume->formattedFileSize }}</p>
                                </div>
                            </div>
                            <a href="{{ route('admin.users.resume.download', [$user, $resume]) }}"
                               class="ml-4 flex-shrink-0 px-3 py-1.5 text-sm font-medium text-indigo-600 hover:text-indigo-800 bg-indigo-50 hover:bg-indigo-100 rounded-md transition-colors">
                                Download
                            </a>
                        </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-sm text-gray-500">No resumes uploaded yet.</p>
                @endif
            </div>
            @endif

            <!-- Documents Section -->
            @if($user->documents->count() > 0)
            <div class="bg-white shadow rounded-lg p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Documents</h3>
                <div class="space-y-3">
                    @foreach($user->documents as $doc)
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                        <div class="flex items-center min-w-0">
                            <svg class="w-8 h-8 text-blue-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z" clip-rule="evenodd"/>
                            </svg>
                            <div class="ml-3 min-w-0">
                                <p class="text-sm font-medium text-gray-900 truncate">{{ $doc->document_name ?? $doc->file_name }}</p>
                                <p class="text-xs text-gray-500">
                                    @if($doc->document_number)
                                        #{{ $doc->document_number }} &middot;
                                    @endif
                                    {{ $doc->fileSizeFormatted }}
                                </p>
                            </div>
                        </div>
                        <a href="{{ route('admin.users.document.download', [$user, $doc]) }}"
                           class="ml-4 flex-shrink-0 px-3 py-1.5 text-sm font-medium text-indigo-600 hover:text-indigo-800 bg-indigo-50 hover:bg-indigo-100 rounded-md transition-colors">
                            Download
                        </a>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            <!-- Job Applications (for job seekers) -->
            @if($user->user_type === 'job_seeker' && $user->jobApplications->count() > 0)
            <div class="bg-white shadow rounded-lg p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Recent Applications</h3>
                <div class="space-y-4">
                    @foreach($user->jobApplications->take(5) as $application)
                    <div class="flex justify-between items-center border-b pb-4 last:border-b-0 last:pb-0">
                        <div>
                            <p class="font-medium text-gray-900">{{ $application->job->title ?? 'Job Deleted' }}</p>
                            <p class="text-sm text-gray-500">Applied {{ $application->created_at->diffForHumans() }}</p>
                        </div>
                        <span class="px-2 py-1 text-xs font-medium rounded-full
                            {{ $application->status === 'pending' ? 'bg-gray-100 text-gray-800' : '' }}
                            {{ $application->status === 'accepted' ? 'bg-green-100 text-green-800' : '' }}
                            {{ $application->status === 'rejected' ? 'bg-red-100 text-red-800' : '' }}">
                            {{ ucfirst($application->status) }}
                        </span>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            <!-- Activity Stats -->
            <div class="bg-white shadow rounded-lg p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Activity Summary</h3>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    @if($user->user_type === 'employer')
                    <div class="text-center p-4 bg-gray-50 rounded-lg">
                        <p class="text-2xl font-bold text-indigo-600">{{ $user->jobs->count() }}</p>
                        <p class="text-sm text-gray-500">Jobs Posted</p>
                    </div>
                    @endif
                    @if($user->user_type === 'job_seeker')
                    <div class="text-center p-4 bg-gray-50 rounded-lg">
                        <p class="text-2xl font-bold text-indigo-600">{{ $user->jobApplications->count() }}</p>
                        <p class="text-sm text-gray-500">Applications</p>
                    </div>
                    <div class="text-center p-4 bg-gray-50 rounded-lg">
                        <p class="text-2xl font-bold text-indigo-600">{{ $user->education->count() }}</p>
                        <p class="text-sm text-gray-500">Education</p>
                    </div>
                    <div class="text-center p-4 bg-gray-50 rounded-lg">
                        <p class="text-2xl font-bold text-indigo-600">{{ $user->experience->count() }}</p>
                        <p class="text-sm text-gray-500">Experience</p>
                    </div>
                    <div class="text-center p-4 bg-gray-50 rounded-lg">
                        <p class="text-2xl font-bold text-indigo-600">{{ $user->skills->count() }}</p>
                        <p class="text-sm text-gray-500">Skills</p>
                    </div>
                    <div class="text-center p-4 bg-gray-50 rounded-lg">
                        <p class="text-2xl font-bold text-indigo-600">{{ $user->resumes->count() }}</p>
                        <p class="text-sm text-gray-500">Resumes</p>
                    </div>
                    @php
                        $filledFields = collect([
                            $user->profile?->headline,
                            $user->profile?->bio,
                            $user->profile?->location,
                            $user->profile?->current_job_title,
                            $user->profile?->date_of_birth,
                            $user->profile?->nationality,
                            $user->phone,
                            $user->avatar,
                        ])->filter()->count();
                        $totalFields = 8;
                        $dataPoints = $filledFields + $user->education->count() + $user->experience->count() + $user->skills->count() + $user->resumes->count();
                        $completeness = min(100, round(($dataPoints / 12) * 100));
                    @endphp
                    <div class="text-center p-4 bg-gray-50 rounded-lg md:col-span-2">
                        <p class="text-2xl font-bold {{ $completeness >= 70 ? 'text-green-600' : ($completeness >= 40 ? 'text-yellow-600' : 'text-red-600') }}">{{ $completeness }}%</p>
                        <p class="text-sm text-gray-500">Profile Completeness</p>
                        <div class="mt-2 w-full bg-gray-200 rounded-full h-2">
                            <div class="h-2 rounded-full {{ $completeness >= 70 ? 'bg-green-500' : ($completeness >= 40 ? 'bg-yellow-500' : 'bg-red-500') }}" style="width: {{ $completeness }}%"></div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
