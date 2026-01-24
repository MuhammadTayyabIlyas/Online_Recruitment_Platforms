@extends('layouts.employer')

@section('title', 'Subscription Packages')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="text-center mb-12">
        <span class="inline-flex items-center rounded-full bg-indigo-100 px-4 py-2 text-sm font-medium text-indigo-700 mb-4">
            🔥 Limited Time Offer
        </span>
        <h1 class="text-4xl font-bold text-gray-900 mb-4">Unlock Premium Hiring Features</h1>
        <p class="text-xl text-gray-600 max-w-3xl mx-auto">Choose the perfect plan to access our curated candidate database, post jobs, and streamline your recruitment process with powerful tools designed for modern employers.</p>
    </div>

    @if(!$hasCompany)
        <div class="mb-8 bg-yellow-50 border-l-4 border-yellow-400 p-6">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-6 w-6 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm text-yellow-700">
                        Please <a href="{{ route('employer.company.create') }}" class="font-medium underline">create your company profile</a> first before requesting access to packages.
                    </p>
                </div>
            </div>
        </div>
    @endif

    @if($isApproved)
        <div class="mb-8 bg-green-50 border-l-4 border-green-400 p-6">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-6 w-6 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm text-green-700 font-medium">
                        ✓ Your CV access has been approved! You can now search and view candidate profiles.
                    </p>
                </div>
            </div>
        </div>
    @endif

    <!-- Packages Grid -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-12">
        @forelse($packages->take(3) as $package)
            <div class="bg-white rounded-2xl shadow-xl border-2 {{ $loop->iteration === 2 ? 'border-indigo-500 transform scale-105' : 'border-gray-200' }} overflow-hidden">
                @if($loop->iteration === 2)
                    <div class="bg-gradient-to-r from-indigo-600 to-purple-600 text-white text-center py-2 font-semibold text-sm">
                        MOST POPULAR
                    </div>
                @endif

                <div class="p-8">
                    <div class="mb-4">
                        <h3 class="text-2xl font-bold text-gray-900 mb-1">{{ $package->name }}</h3>
                        @if($package->slug == 'professional')
                            <span class="inline-flex items-center rounded-full bg-gradient-to-r from-indigo-600 to-purple-600 px-3 py-1 text-xs font-semibold text-white">
                                Most Popular
                            </span>
                        @endif
                    </div>
                    <div class="mb-6">
                        <span class="text-5xl font-bold text-gray-900">€{{ number_format($package->price, 0) }}</span>
                        <span class="text-gray-600">/month</span>
                    </div>

                    @if($package->description)
                        <p class="text-gray-600 mb-6 text-sm leading-relaxed">{{ $package->description }}</p>
                    @endif

                    <ul class="space-y-3 mb-8">
                        @foreach($package->features as $feature)
                            <li class="flex items-start">
                                <svg class="w-6 h-6 text-green-500 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                                <span class="text-gray-700">{{ $feature }}</span>
                            </li>
                        @endforeach
                    </ul>

                    <div class="mt-8">
                        @if(!$hasCompany)
                            <button class="w-full bg-gray-300 text-gray-500 cursor-not-allowed py-3 px-4 rounded-lg font-semibold transition-all" disabled>
                                Create Company First
                            </button>
                        @elseif($isApproved)
                            <div class="text-center">
                                <div class="inline-flex items-center text-green-600 font-semibold">
                                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                    </svg>
                                    Access Already Approved
                                </div>
                            </div>
                        @else
                            <a href="{{ route('employer.subscription') }}" class="w-full bg-gradient-to-r from-indigo-600 to-purple-600 text-white py-3 px-4 rounded-lg font-semibold hover:from-indigo-700 hover:to-purple-700 transition-all transform hover:scale-105 shadow-lg block text-center">
                                Contact Sales
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-3 text-center py-12">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900">No packages available</h3>
                <p class="mt-1 text-sm text-gray-500">Please check back later or contact support.</p>
            </div>
        @endforelse
    </div>

    <!-- Contact Admin Section -->
    @if(!$isApproved && $hasCompany)
        <div class="bg-gradient-to-r from-indigo-50 to-purple-50 rounded-2xl shadow-lg p-8 border border-indigo-200">
            <div class="text-center">
                <svg class="mx-auto h-16 w-16 text-indigo-600 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                </svg>
                <h2 class="text-2xl font-bold text-gray-900 mb-3">Ready to Access Our Candidate Database?</h2>
                <p class="text-lg text-gray-700 mb-6">Contact our admin team to request access and discuss payment options.</p>

                <div class="bg-white rounded-lg p-6 mb-6">
                    <h3 class="font-semibold text-gray-900 mb-4">How it works:</h3>
                    <ol class="text-left space-y-3 max-w-2xl mx-auto">
                        <li class="flex items-start">
                            <span class="flex-shrink-0 w-8 h-8 bg-indigo-100 text-indigo-600 rounded-full flex items-center justify-center font-bold mr-3">1</span>
                            <span class="text-gray-700 pt-1">Choose your preferred package and contact admin via email or phone</span>
                        </li>
                        <li class="flex items-start">
                            <span class="flex-shrink-0 w-8 h-8 bg-indigo-100 text-indigo-600 rounded-full flex items-center justify-center font-bold mr-3">2</span>
                            <span class="text-gray-700 pt-1">Make payment through bank transfer or other agreed method</span>
                        </li>
                        <li class="flex items-start">
                            <span class="flex-shrink-0 w-8 h-8 bg-indigo-100 text-indigo-600 rounded-full flex items-center justify-center font-bold mr-3">3</span>
                            <span class="text-gray-700 pt-1">Admin will verify payment and approve your CV access</span>
                        </li>
                        <li class="flex items-start">
                            <span class="flex-shrink-0 w-8 h-8 bg-indigo-100 text-indigo-600 rounded-full flex items-center justify-center font-bold mr-3">4</span>
                            <span class="text-gray-700 pt-1">Start searching and viewing candidate profiles immediately</span>
                        </li>
                    </ol>
                </div>

                <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
                    <a href="mailto:admin@placemenet.net?subject=Package Subscription Request - {{ auth()->user()->company->company_name ?? 'Company' }}"
                       class="inline-flex items-center px-8 py-3 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 shadow-lg transition-all hover:scale-105">
                        <svg class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                        Email Admin
                    </a>
                    <a href="tel:+1234567890"
                       class="inline-flex items-center px-8 py-3 bg-white text-indigo-600 border-2 border-indigo-600 rounded-lg hover:bg-indigo-50 shadow-lg transition-all hover:scale-105">
                        <svg class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                        </svg>
                        Call Us
                    </a>
                </div>
            </div>
        </div>
    @endif

    <!-- Social Proof & Trust Section -->
    <div class="mt-16 grid grid-cols-1 md:grid-cols-3 gap-8">
        <div class="text-center">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-green-100 rounded-full mb-4">
                <svg class="w-8 h-8 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
            </div>
            <h3 class="text-lg font-semibold text-gray-900 mb-2">Verified Candidates</h3>
            <p class="text-gray-600 text-sm">All profiles are manually verified for quality and authenticity</p>
        </div>
        <div class="text-center">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-indigo-100 rounded-full mb-4">
                <svg class="w-8 h-8 text-indigo-600" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"/>
                </svg>
            </div>
            <h3 class="text-lg font-semibold text-gray-900 mb-2">Secure Payment</h3>
            <p class="text-gray-600 text-sm">Bank transfer and secure payment methods available</p>
        </div>
        <div class="text-center">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-purple-100 rounded-full mb-4">
                <svg class="w-8 h-8 text-purple-600" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                </svg>
            </div>
            <h3 class="text-lg font-semibold text-gray-900 mb-2">Expert Support</h3>
            <p class="text-gray-600 text-sm">Get help from our dedicated recruitment specialists</p>
        </div>
    </div>

    <!-- FAQ Section -->
    <div class="mt-16 bg-white rounded-2xl shadow-lg border border-gray-200 p-8">
        <h2 class="text-2xl font-bold text-center text-gray-900 mb-8">Frequently Asked Questions</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <div>
                <h3 class="font-semibold text-gray-900 mb-2">What happens after I make payment?</h3>
                <p class="text-gray-600 text-sm">Once payment is verified, our admin team will immediately approve your CV access and you'll receive a confirmation email with login instructions.</p>
            </div>
            <div>
                <h3 class="font-semibold text-gray-900 mb-2">Can I upgrade my package later?</h3>
                <p class="text-gray-600 text-sm">Yes! You can upgrade to a higher tier package at any time. We'll prorate the difference based on your remaining days.</p>
            </div>
            <div>
                <h3 class="font-semibold text-gray-900 mb-2">How do I search the CV database?</h3>
                <p class="text-gray-600 text-sm">Use advanced filters like skills, experience, location, and availability to find the perfect candidates quickly.</p>
            </div>
            <div>
                <h3 class="font-semibold text-gray-900 mb-2">What payment methods do you accept?</h3>
                <p class="text-gray-600 text-sm">We accept bank transfers and can discuss other payment methods that work best for your organization.</p>
            </div>
        </div>
    </div>
</div>
</div>
@endsection
