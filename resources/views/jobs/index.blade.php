@extends('layouts.app')

@section('title', 'Browse Jobs')
@section('meta_description', 'Search verified roles from top employers. Filter by title, location, type, and salary. Quick links to study programs and visa paths to keep your options open.')

@section('content')
<div class="-my-6">
    {{-- Hero --}}
    <section class="bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 md:py-14">
            <div class="grid md:grid-cols-2 gap-10 items-center">
                <div>
                    <div class="inline-flex items-center px-3 py-1 rounded-full bg-blue-50 text-blue-700 text-xs font-semibold mb-4">
                        <span class="w-2 h-2 rounded-full bg-blue-500 mr-2"></span>
                        Fresh roles posted daily
                    </div>
                    <h1 class="text-3xl sm:text-4xl font-bold text-gray-900 leading-tight mb-3">
                        Find verified jobs and apply faster
                    </h1>
                    <p class="text-lg text-gray-700 mb-6">
                        Search openings from trusted employers, save favorites, and apply in one place. Your next offer starts here.
                    </p>
                    <div class="flex flex-col sm:flex-row gap-3">
                        <a href="#job-search" class="inline-flex items-center justify-center gap-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-3 rounded-lg transition">
                            Start searching
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                            </svg>
                        </a>
                        <a href="{{ route('register') }}" class="inline-flex items-center justify-center gap-2 border border-blue-200 text-blue-700 hover:bg-blue-50 font-semibold px-6 py-3 rounded-lg transition">
                            Upload your resume
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
                            </svg>
                        </a>
                    </div>
                    <div class="mt-6 grid grid-cols-2 gap-3 text-sm">
                        <div class="p-3 rounded-xl bg-blue-50 text-blue-800 font-semibold">Curated employers</div>
                        <div class="p-3 rounded-xl bg-indigo-50 text-indigo-800 font-semibold">Skill-based matching</div>
                        <div class="p-3 rounded-xl bg-blue-50 text-blue-800 font-semibold">Salary visibility</div>
                        <div class="p-3 rounded-xl bg-indigo-50 text-indigo-800 font-semibold">Saved searches</div>
                    </div>
                </div>
                <div class="bg-white rounded-2xl shadow-xl border border-gray-100 p-6 space-y-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-500">Top categories</p>
                            <p class="text-base font-semibold text-gray-900">Tech · Marketing · Ops · Finance</p>
                        </div>
                        <span class="px-3 py-1 rounded-full bg-green-100 text-green-700 text-xs font-semibold">95% filled</span>
                    </div>
                    <div class="grid grid-cols-2 gap-3 text-sm text-gray-800">
                        <div class="p-3 rounded-xl bg-gray-50 border border-gray-100">
                            Remote & hybrid friendly
                        </div>
                        <div class="p-3 rounded-xl bg-gray-50 border border-gray-100">
                            Entry to senior levels
                        </div>
                        <div class="p-3 rounded-xl bg-gray-50 border border-gray-100">
                            Fast-track applications
                        </div>
                        <div class="p-3 rounded-xl bg-gray-50 border border-gray-100">
                            Saved resumes & profiles
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Search module --}}
    <section id="job-search" class="bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
            <div class="bg-white rounded-2xl shadow-xl border border-gray-100 p-4 md:p-6">
                <livewire:job-search />
            </div>
        </div>
    </section>

    {{-- Cross-navigation --}}
    <section class="bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
            <div class="text-center mb-8">
                <h2 class="text-2xl md:text-3xl font-bold text-gray-900 mb-2">Broaden your options</h2>
                <p class="text-gray-700">Keep study and relocation paths handy while you apply.</p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="p-6 rounded-2xl bg-gradient-to-br from-blue-50 to-indigo-50 border border-blue-100 shadow-sm flex flex-col gap-3">
                    <div class="flex items-center justify-between">
                        <p class="text-sm text-blue-700 font-semibold">Jobs</p>
                        <span class="px-3 py-1 rounded-full bg-white text-blue-700 text-xs font-semibold">Live</span>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900">Keep applying</h3>
                    <p class="text-sm text-gray-700">Use saved searches and alerts to jump on new roles.</p>
                    <a href="{{ route('jobs.index') }}" class="inline-flex items-center gap-2 text-blue-700 font-semibold hover:text-blue-900">
                        Browse jobs
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                        </svg>
                    </a>
                </div>
                <div class="p-6 rounded-2xl bg-gradient-to-br from-indigo-50 to-purple-50 border border-indigo-100 shadow-sm flex flex-col gap-3">
                    <div class="flex items-center justify-between">
                        <p class="text-sm text-indigo-700 font-semibold">Study programs</p>
                        <span class="px-3 py-1 rounded-full bg-white text-indigo-700 text-xs font-semibold">92% offers</span>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900">European degrees</h3>
                    <p class="text-sm text-gray-700">Compare tuition and deadlines; secure a seat this intake.</p>
                    <a href="{{ route('study-programs.index') }}" class="inline-flex items-center gap-2 text-indigo-700 font-semibold hover:text-indigo-900">
                        Explore programs
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                        </svg>
                    </a>
                </div>
                <div class="p-6 rounded-2xl bg-gradient-to-br from-blue-50 to-teal-50 border border-teal-100 shadow-sm flex flex-col gap-3">
                    <div class="flex items-center justify-between">
                        <p class="text-sm text-teal-700 font-semibold">Visa & residency</p>
                        <span class="px-3 py-1 rounded-full bg-white text-teal-700 text-xs font-semibold">Guided</span>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900">Move to Europe</h3>
                    <p class="text-sm text-gray-700">Golden, Digital Nomad, Passive Income, Startup, or Skilled paths.</p>
                    <a href="{{ route('visa.index') }}" class="inline-flex items-center gap-2 text-teal-700 font-semibold hover:text-teal-900">
                        See pathways
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
