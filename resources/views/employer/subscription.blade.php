@extends('layouts.employer')

@section('title', 'Subscription')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="bg-gradient-to-r from-indigo-50 to-purple-50 rounded-2xl shadow-lg p-8 border border-indigo-200">
        <div class="text-center">
            <svg class="mx-auto h-16 w-16 text-indigo-600 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
            </svg>
            <h2 class="text-3xl font-bold text-gray-900 mb-3">Ready to Access Our Candidate Database?</h2>
            <p class="text-lg text-gray-700 mb-6">Contact our admin team to request access and discuss payment options.</p>

            <div class="bg-white rounded-lg p-6 mb-6 max-w-3xl mx-auto">
                <h3 class="font-semibold text-gray-900 mb-4">How it works:</h3>
                <ol class="text-left space-y-3">
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
                <a href="mailto:admin@placemenet.net?subject=Package Subscription Request"
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
</div>
@endsection
