@extends('layouts.app')

@section('title', 'Data Privacy & GDPR Compliance')

@section('content')
<div class="py-10">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
        <div class="bg-white/95 rounded-3xl shadow-2xl p-8 md:p-12">
            <p class="uppercase text-sm tracking-[0.3em] text-blue-500 mb-3">Our Commitment</p>
            <h1 class="text-3xl md:text-4xl font-extrabold text-gray-900 mb-6">Data Privacy & GDPR Compliance</h1>
            <p class="text-gray-600 text-lg mb-4">
                PlacemeNet is a European-operated platform. We follow the General Data Protection Regulation (GDPR) and local labor laws to keep every worker, employer, and partner safe while using our services.
            </p>
            <p class="text-gray-600">
                This page explains how we collect, store, and protect your information—including how we use minimal, purpose-driven cookies.
            </p>
            <div class="mt-6 flex flex-wrap gap-3">
                <a href="#cookies-policy" class="inline-flex items-center gap-2 px-5 py-3 rounded-xl bg-blue-600 text-white font-semibold shadow hover:bg-blue-700 transition">
                    {{ __('View Cookies Policy') }}
                    <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 3h7m0 0v7m0-7L10 14" />
                    </svg>
                </a>
                <a href="{{ route('home') }}" class="inline-flex items-center gap-2 px-5 py-3 rounded-xl border border-gray-200 text-gray-700 font-semibold hover:border-blue-200 hover:text-blue-700 transition">
                    {{ __('Back to Home') }}
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="bg-white rounded-2xl shadow-xl p-6 space-y-3">
                <h2 class="text-xl font-bold text-gray-900">Data We Collect</h2>
                <p class="text-gray-600">We only gather data that is essential for recruitment:</p>
                <ul class="list-disc pl-5 text-gray-600">
                    <li>Profile information submitted by workers or employers</li>
                    <li>Job postings, applications, and chat history</li>
                    <li>Verification documents provided voluntarily</li>
                </ul>
            </div>
            <div class="bg-white rounded-2xl shadow-xl p-6 space-y-3">
                <h2 class="text-xl font-bold text-gray-900">How We Use It</h2>
                <p class="text-gray-600">All information is used solely to:</p>
                <ul class="list-disc pl-5 text-gray-600">
                    <li>Match workers with verified employers</li>
                    <li>Prevent fraud and fake agents</li>
                    <li>Comply with legal obligations and audits</li>
                </ul>
            </div>
        </div>

        <div id="cookies-policy" class="bg-white rounded-2xl shadow-xl p-6 space-y-4 scroll-mt-20">
            <h2 class="text-2xl font-semibold text-gray-900">Cookies Policy</h2>
            <p class="text-gray-600">
                We use a minimal set of cookies to keep the site secure and user-friendly. These cookies never sell your data and are used only for the purposes below.
            </p>
            <ul class="list-disc pl-5 text-gray-600 space-y-1">
                <li><strong>Essential</strong>: session/login state, CSRF protection, language and locale preferences.</li>
                <li><strong>Performance</strong>: basic, aggregated analytics to improve reliability (no cross-site tracking).</li>
                <li><strong>Preference</strong>: remember optional choices like “saved filters” or “recent searches”.</li>
            </ul>
            <p class="text-gray-600">
                You can clear cookies in your browser at any time. Essential cookies are required for secure login and applications to function correctly.
            </p>
            <a href="{{ route('home') }}" class="inline-flex items-center gap-2 px-5 py-3 rounded-xl bg-blue-600 text-white font-semibold shadow hover:bg-blue-700 transition">
                {{ __('Go to Homepage') }}
                <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                </svg>
            </a>
        </div>

        <div class="bg-white rounded-2xl shadow-xl p-6 space-y-4">
            <h2 class="text-2xl font-semibold text-gray-900">Your Rights Under GDPR</h2>
            <p class="text-gray-600">You can exercise these rights anytime:</p>
            <ul class="list-disc pl-5 text-gray-600 space-y-1">
                <li>Access your data</li>
                <li>Request corrections</li>
                <li>Ask for deletion (“right to be forgotten”)</li>
                <li>Export a copy of your records</li>
                <li>Withdraw consent and close your account</li>
            </ul>
            <p class="text-gray-600">
                Send requests to <a href="mailto:support@placemenet.net" class="text-blue-600 font-semibold">support@placemenet.net</a> or <a href="mailto:legal@placemenet.net" class="text-blue-600 font-semibold">legal@placemenet.net</a>. We reply within 72 hours.
            </p>
        </div>

        <div class="bg-white rounded-2xl shadow-xl p-6 space-y-4">
            <h2 class="text-2xl font-semibold text-gray-900">Data Storage & Security</h2>
            <ul class="list-disc pl-5 text-gray-600 space-y-1">
                <li>Hosted on secure EU/EEA-based servers with encryption at rest and in transit.</li>
                <li>Role-based access control for our internal team.</li>
                <li>Audit logs for every change or export.</li>
                <li>Data minimization practices—if we don’t need it, we delete it.</li>
            </ul>
        </div>

        <div class="bg-white rounded-2xl shadow-xl p-6 space-y-4">
            <h2 class="text-2xl font-semibold text-gray-900">Third Parties</h2>
            <p class="text-gray-600">
                We never sell or rent personal data. Trusted partners (e.g., payment gateways or background-check providers) only receive data when required for the service you chose, and they must also comply with GDPR.
            </p>
        </div>

        <div class="bg-gradient-to-r from-blue-50 to-indigo-50 rounded-2xl shadow-xl p-6 space-y-4 border border-blue-200">
            <h2 class="text-2xl font-semibold text-gray-900">Multiple Jurisdictions</h2>
            <p class="text-gray-600">
                PlaceMeNet operates through multiple legal entities in different jurisdictions. The data controller for your personal data depends on the service you access and will be identified on the relevant service page. Data is processed in accordance with applicable data protection laws, including GDPR and, where applicable, UK GDPR.
            </p>
            <p class="text-gray-600">
                The applicable legal entity, governing law, and jurisdiction are determined by the specific service page accessed by the user. Users must review the jurisdiction notice on each service page before proceeding.
            </p>
        </div>

        <div class="bg-white rounded-2xl shadow-xl p-6 space-y-4">
            <h2 class="text-2xl font-semibold text-gray-900">Updates</h2>
            <p class="text-gray-600">
                Any changes to this policy will appear on this page and be time-stamped. Continuing to use PlacemeNet means you accept the updated terms.
            </p>
        </div>
    </div>
</div>
@endsection
