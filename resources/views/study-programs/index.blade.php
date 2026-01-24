@extends('layouts.app')

@section('title', 'Study Abroad in Europe | PlaceMeNet')
@section('meta_description', 'Find and compare the best European universities, degrees, and tuition options. Get tailored picks, application support, and visa guidance to secure your spot faster.')

@section('content')
<div class="-my-6">
    {{-- Hero --}}
    <section class="bg-white">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-12 md:py-16">
            <div class="grid md:grid-cols-2 gap-10 items-center">
                <div>
                    <div class="inline-flex items-center px-3 py-1 rounded-full bg-indigo-50 text-indigo-700 text-xs font-semibold mb-4">
                        <span class="w-2 h-2 rounded-full bg-indigo-500 mr-2"></span>
                        Guaranteed shortlist support
                    </div>
                    <h1 class="text-3xl sm:text-4xl lg:text-5xl font-bold text-gray-900 leading-tight mb-4">
                        Study in Europe without the guesswork
                    </h1>
                    <p class="text-lg text-gray-700 mb-6">
                        Compare verified programs, tuition, and entry requirements. We help you apply with confidence and keep your visa on track.
                    </p>
                    <div class="flex flex-col sm:flex-row gap-3 mb-6">
                        <a href="#search"
                           class="inline-flex items-center justify-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold px-6 py-3 rounded-lg transition-all">
                            Start searching
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                            </svg>
                        </a>
                        <a href="{{ route('contact') }}"
                           class="inline-flex items-center justify-center gap-2 border border-indigo-200 text-indigo-700 hover:bg-indigo-50 font-semibold px-6 py-3 rounded-lg transition-all">
                            Talk to an advisor
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                            </svg>
                        </a>
                    </div>
                    <ul class="space-y-2 text-gray-700">
                        <li class="flex items-start gap-2"><span class="text-green-500">✔</span><span>Handpicked degrees in tech, business, engineering, health, and design.</span></li>
                        <li class="flex items-start gap-2"><span class="text-green-500">✔</span><span>Scholarship and tuition transparency so you know real costs.</span></li>
                        <li class="flex items-start gap-2"><span class="text-green-500">✔</span><span>Application and visa guidance to hit deadlines on time.</span></li>
                    </ul>
                </div>
                <div class="bg-white rounded-2xl shadow-xl border border-indigo-50 p-6 space-y-4">
                    <div class="flex items-center justify-between">
                        <div class="text-sm text-gray-500">Popular destinations</div>
                        <div class="flex -space-x-2">
                            <span class="w-8 h-8 rounded-full bg-indigo-100 flex items-center justify-center text-lg">🇩🇪</span>
                            <span class="w-8 h-8 rounded-full bg-indigo-100 flex items-center justify-center text-lg">🇳🇱</span>
                            <span class="w-8 h-8 rounded-full bg-indigo-100 flex items-center justify-center text-lg">🇸🇪</span>
                            <span class="w-8 h-8 rounded-full bg-indigo-100 flex items-center justify-center text-lg">🇫🇷</span>
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-3 text-sm">
                        <div class="p-3 rounded-xl bg-indigo-50">
                            <p class="text-indigo-900 font-semibold">Low tuition</p>
                            <p class="text-indigo-700">From €3,000/yr</p>
                        </div>
                        <div class="p-3 rounded-xl bg-indigo-50">
                            <p class="text-indigo-900 font-semibold">Fast decisions</p>
                            <p class="text-indigo-700">4–8 weeks</p>
                        </div>
                        <div class="p-3 rounded-xl bg-indigo-50">
                            <p class="text-indigo-900 font-semibold">Career visas</p>
                            <p class="text-indigo-700">Post-study options</p>
                        </div>
                        <div class="p-3 rounded-xl bg-indigo-50">
                            <p class="text-indigo-900 font-semibold">Scholarships</p>
                            <p class="text-indigo-700">Highlighted upfront</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-3 p-3 rounded-xl bg-gray-50 border border-gray-100">
                        <div class="w-10 h-10 rounded-full bg-green-100 flex items-center justify-center">
                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Acceptance guidance</p>
                            <p class="text-base font-semibold text-gray-900">Boost your offer chances</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Proof --}}
    <section class="bg-gray-50">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
            <div class="grid sm:grid-cols-2 md:grid-cols-4 gap-4">
                <div class="p-4 rounded-xl bg-white shadow-sm border border-gray-100">
                    <p class="text-2xl font-bold text-gray-900">300+</p>
                    <p class="text-sm text-gray-600">Partner universities and schools</p>
                </div>
                <div class="p-4 rounded-xl bg-white shadow-sm border border-gray-100">
                    <p class="text-2xl font-bold text-gray-900">15k</p>
                    <p class="text-sm text-gray-600">Programs with tuition transparency</p>
                </div>
                <div class="p-4 rounded-xl bg-white shadow-sm border border-gray-100">
                    <p class="text-2xl font-bold text-gray-900">92%</p>
                    <p class="text-sm text-gray-600">Applicants get an offer with our checklist</p>
                </div>
                <div class="p-4 rounded-xl bg-white shadow-sm border border-gray-100">
                    <p class="text-2xl font-bold text-gray-900">4–8 weeks</p>
                    <p class="text-sm text-gray-600">Typical decision window</p>
                </div>
            </div>
        </div>
    </section>

    {{-- Search --}}
    <section id="search" class="bg-white">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="flex flex-col md:flex-row md:items-end md:justify-between mb-6 gap-4">
                <div>
                    <h2 class="text-2xl md:text-3xl font-bold text-gray-900 mb-2">Search programs tailored to you</h2>
                    <p class="text-gray-700">Filter by country, degree, budget, intake, and study mode. Save favorites and apply in one place.</p>
                </div>
                <a href="{{ route('contact') }}" class="inline-flex items-center gap-2 text-indigo-700 font-semibold hover:text-indigo-900">
                    Need a shortlist done for you?
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                    </svg>
                </a>
            </div>
            <div class="bg-white rounded-2xl shadow-xl border border-gray-100 p-4">
                <livewire:study-program-search />
            </div>
        </div>
    </section>

    {{-- How it works --}}
    <section class="bg-gray-50">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="text-center mb-10">
                <h2 class="text-2xl md:text-3xl font-bold text-gray-900 mb-3">Get an offer and arrive on time</h2>
                <p class="text-gray-700">We keep you on track from shortlist to visa.</p>
            </div>
            <div class="grid md:grid-cols-3 gap-6">
                <div class="p-6 bg-white rounded-xl shadow-sm border border-gray-100">
                    <div class="w-10 h-10 rounded-full bg-indigo-100 text-indigo-700 font-bold flex items-center justify-center mb-4">1</div>
                    <h3 class="font-semibold text-gray-900 mb-2">Build your shortlist</h3>
                    <p class="text-gray-700 text-sm">Filter programs and bookmark your matches. We highlight admission likelihood and tuition fit.</p>
                </div>
                <div class="p-6 bg-white rounded-xl shadow-sm border border-gray-100">
                    <div class="w-10 h-10 rounded-full bg-indigo-100 text-indigo-700 font-bold flex items-center justify-center mb-4">2</div>
                    <h3 class="font-semibold text-gray-900 mb-2">Apply with confidence</h3>
                    <p class="text-gray-700 text-sm">Upload documents once. Get checklist reminders and review before submission.</p>
                </div>
                <div class="p-6 bg-white rounded-xl shadow-sm border border-gray-100">
                    <div class="w-10 h-10 rounded-full bg-indigo-100 text-indigo-700 font-bold flex items-center justify-center mb-4">3</div>
                    <h3 class="font-semibold text-gray-900 mb-2">Visa & arrival ready</h3>
                    <p class="text-gray-700 text-sm">Post-offer support for visas, housing tips, and arrivals so you land on schedule.</p>
                </div>
            </div>
        </div>
    </section>

    {{-- CTA --}}
    <section class="bg-gradient-to-r from-indigo-600 to-blue-700">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-12 text-center text-white">
            <h2 class="text-2xl md:text-3xl font-bold mb-3">Ready to secure your place?</h2>
            <p class="text-blue-100 mb-6">Start with a search or let us build a custom list for you.</p>
            <div class="flex flex-col sm:flex-row gap-3 justify-center">
                <a href="#search" class="inline-flex items-center justify-center gap-2 bg-white text-indigo-700 font-semibold px-6 py-3 rounded-lg hover:bg-blue-50 transition">
                    Find programs now
                </a>
                <a href="{{ route('contact') }}" class="inline-flex items-center justify-center gap-2 border border-white text-white font-semibold px-6 py-3 rounded-lg hover:bg-white/10 transition">
                    Book a 15-min call
                </a>
            </div>
        </div>
    </section>
</div>
@endsection
