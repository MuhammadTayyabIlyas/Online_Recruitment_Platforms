@extends('layouts.app')

@section('title', $job->title ?? 'Job Details')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <!-- Breadcrumb -->
    <nav class="mb-6">
        <ol class="flex items-center space-x-2 text-sm text-gray-500">
            <li><a href="{{ route('jobs.index') }}" class="hover:text-indigo-600">Jobs</a></li>
            <li><span class="mx-2">/</span></li>
            <li class="text-gray-900">{{ $job->title }}</li>
        </ol>
    </nav>

    <div class="flex flex-col lg:flex-row gap-6">
        <!-- Main Content -->
        <div class="lg:w-2/3">
            <div class="bg-white shadow rounded-lg overflow-hidden">
                <!-- Header -->
                <div class="p-6 border-b border-gray-200">
                    <div class="flex items-start justify-between">
                        <div class="flex items-center gap-4">
                            @if($job->company && $job->company->logo)
                                <img src="{{ $job->company->logo_url }}" alt="{{ $job->company->name }}"
                                     class="w-16 h-16 rounded-lg object-cover">
                            @else
                                <div class="w-16 h-16 bg-gray-200 rounded-lg flex items-center justify-center">
                                    <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                    </svg>
                                </div>
                            @endif
                            <div>
                                <h1 class="text-2xl font-bold text-gray-900">{{ $job->title }}</h1>
                                <p class="text-lg text-gray-600">{{ $job->company->company_name ?? 'Company' }}</p>
                            </div>
                        </div>
                        @if($job->is_featured)
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800">
                                Featured
                            </span>
                        @endif
                    </div>

                    <!-- Meta Info -->
                    <div class="flex flex-wrap gap-4 mt-4">
                        <span class="inline-flex items-center text-gray-600">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            </svg>
                            {{ $job->location }}
                        </span>
                        @if($job->jobType)
                            <span class="inline-flex items-center text-gray-600">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                                {{ $job->jobType->name }}
                            </span>
                        @endif
                        @if(!$job->hide_salary && ($job->min_salary || $job->max_salary))
                            <span class="inline-flex items-center text-gray-600">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                @if($job->min_salary && $job->max_salary)
                                    ${{ number_format($job->min_salary) }} - ${{ number_format($job->max_salary) }}
                                @elseif($job->min_salary)
                                    From ${{ number_format($job->min_salary) }}
                                @else
                                    Up to ${{ number_format($job->max_salary) }}
                                @endif
                            </span>
                        @endif
                        <span class="inline-flex items-center text-gray-600">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Posted {{ $job->created_at->diffForHumans() }}
                        </span>
                    </div>
                </div>

                <!-- Description -->
                <div class="p-6">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">Job Description</h2>
                    <div class="prose max-w-none text-gray-600">
                        {!! nl2br(e($job->description)) !!}
                    </div>

                    @if($job->requirements)
                        <h2 class="text-lg font-semibold text-gray-900 mt-6 mb-4">Requirements</h2>
                        <div class="prose max-w-none text-gray-600">
                            {!! nl2br(e($job->requirements)) !!}
                        </div>
                    @endif

                    @if($job->benefits)
                        <h2 class="text-lg font-semibold text-gray-900 mt-6 mb-4">Benefits</h2>
                        <div class="prose max-w-none text-gray-600">
                            {!! nl2br(e($job->benefits)) !!}
                        </div>
                    @endif

                    <!-- Skills -->
                    @if($job->skills && $job->skills->count())
                        <h2 class="text-lg font-semibold text-gray-900 mt-6 mb-4">Required Skills</h2>
                        <div class="flex flex-wrap gap-2">
                            @foreach($job->skills as $skill)
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-indigo-100 text-indigo-800">
                                    {{ $skill->name }}
                                </span>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="lg:w-1/3">
            <!-- Apply Card -->
            <div class="bg-white shadow rounded-lg p-6 mb-6">
                @auth
                    @if(auth()->user()->hasRole('job_seeker'))
                        @if($job->expires_at && $job->expires_at->isPast())
                            <div class="text-center">
                                <p class="text-red-600 font-medium">This job is no longer accepting applications.</p>
                            </div>
                        @else
                            <a href="{{ route('jobseeker.applications.create', $job) }}"
                               class="block w-full text-center px-4 py-3 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 font-medium">
                                Apply Now
                            </a>
                            <form action="{{ route('jobseeker.saved.store', $job) }}" method="POST" class="mt-3">
                                @csrf
                                <button type="submit"
                                        class="block w-full text-center px-4 py-3 bg-white border border-gray-300 text-gray-700 rounded-md hover:bg-gray-50 font-medium">
                                    Save Job
                                </button>
                            </form>
                        @endif
                    @else
                        <p class="text-center text-gray-600">Switch to a job seeker account to apply for this job.</p>
                    @endif
                @else
                    <p class="text-center text-gray-600 mb-4">Login to apply for this job</p>
                    <a href="{{ route('login') }}"
                       class="block w-full text-center px-4 py-3 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 font-medium">
                        Login to Apply
                    </a>
                    <a href="{{ route('register') }}"
                       class="block w-full text-center px-4 py-3 mt-3 bg-white border border-gray-300 text-gray-700 rounded-md hover:bg-gray-50 font-medium">
                        Create Account
                    </a>
                @endauth

                @if($job->expires_at)
                    <p class="text-center text-sm text-gray-500 mt-4">
                        Application deadline: {{ $job->expires_at->format('M d, Y') }}
                    </p>
                @endif
            </div>

            <!-- Company Info -->
            @if($job->company)
                <div class="bg-white shadow rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">About the Company</h3>
                    <div class="flex items-center gap-4 mb-4">
                        @if($job->company->logo)
                            <img src="{{ $job->company->logo_url }}" alt="{{ $job->company->name }}"
                                 class="w-12 h-12 rounded-lg object-cover">
                        @else
                            <div class="w-12 h-12 bg-gray-200 rounded-lg flex items-center justify-center">
                                <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                </svg>
                            </div>
                        @endif
                        <div>
                            <h4 class="font-medium text-gray-900">{{ $job->company->company_name }}</h4>
                            @if($job->company->industry)
                                <p class="text-sm text-gray-500">{{ $job->company->industry->name }}</p>
                            @endif
                        </div>
                    </div>
                    @if($job->company->description)
                        <p class="text-gray-600 text-sm">{{ Str::limit($job->company->description, 200) }}</p>
                    @endif
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

@push('scripts')
@php
    $salaryMin = (!$job->hide_salary && $job->min_salary) ? (float) $job->min_salary : null;
    $salaryMax = (!$job->hide_salary && $job->max_salary) ? (float) $job->max_salary : null;
    $jobSchema = [
        '@context' => 'https://schema.org/',
        '@type' => 'JobPosting',
        'title' => $job->title,
        'description' => strip_tags($job->description ?? ''),
        'datePosted' => optional($job->published_at ?? $job->created_at)->toIso8601String(),
        'validThrough' => optional($job->expires_at)->toIso8601String(),
        'employmentType' => $job->jobType->name ?? null,
        'industry' => $job->industry->name ?? null,
        'hiringOrganization' => [
            '@type' => 'Organization',
            'name' => $job->company->company_name ?? $job->company->name ?? 'Employer',
            'sameAs' => $job->company->website ?? null,
            'logo' => $job->company->logo_url ?? null,
        ],
        'jobLocation' => [
            '@type' => 'Place',
            'address' => [
                '@type' => 'PostalAddress',
                'streetAddress' => $job->location,
                'addressLocality' => $job->city,
                'addressRegion' => $job->state,
                'addressCountry' => $job->country,
            ],
        ],
        'applicantLocationRequirements' => [
            '@type' => 'Country',
            'name' => $job->country ?? 'Worldwide'
        ],
        'directApply' => true,
    ];

    if ($salaryMin || $salaryMax) {
        $jobSchema['baseSalary'] = [
            '@type' => 'MonetaryAmount',
            'currency' => $job->salary_currency ?? 'USD',
            'value' => [
                '@type' => 'QuantitativeValue',
                'minValue' => $salaryMin,
                'maxValue' => $salaryMax,
                'unitText' => $job->salary_period ? ucfirst($job->salary_period) : 'YEAR',
            ],
        ];
    }
@endphp
<script type="application/ld+json">
{!! json_encode($jobSchema, JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT) !!}
</script>
@endpush
