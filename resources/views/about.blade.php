@extends('layouts.app')

@section('title', __('About PlaceMeNet'))

@section('content')
@php
    $workingHours = config('placemenet.working_hours');
    $supportEmail = config('placemenet.support_email');
    $legalEmail = config('placemenet.legal_email');
    $whatsappLink = config('placemenet.whatsapp_link');
@endphp
<div class="py-10">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
        <div class="bg-white/90 rounded-3xl shadow-2xl p-8 md:p-12 backdrop-blur-md">
            <p class="uppercase text-sm tracking-[0.3em] text-blue-500 mb-3">{{ __('Our Story') }}</p>
            <h1 class="text-3xl md:text-4xl font-extrabold text-gray-900 mb-6 leading-tight">
                {{ __('Connecting brilliant talent with ambitious employers across Europe.') }}
            </h1>
            <p class="text-gray-600 text-lg mb-6">
                {{ __('PlaceMeNet was founded with a simple promise: simplify recruitment for fast-growing teams and remove the friction job seekers face when chasing their next career milestone. From curated roles to real-time coaching, we fuse technology with a human touch to build careers that matter.') }}
            </p>
            <div class="flex flex-col sm:flex-row gap-4">
                <a href="{{ route('contact') }}" class="inline-flex items-center justify-center px-6 py-3 rounded-full bg-blue-600 text-white font-semibold shadow-lg hover:bg-blue-500 transition">
                    {{ __('Contact Us') }}
                </a>
                <a href="{{ $whatsappLink }}" target="{{ $whatsappLink ? '_blank' : '_self' }}" rel="noopener" class="inline-flex items-center justify-center px-6 py-3 rounded-full border border-blue-600 text-blue-700 font-semibold hover:bg-blue-50 transition">
                    {{ __('Chat on WhatsApp') }}
                </a>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-xl p-6 md:p-8 space-y-8">
            <div>
                <h3 class="text-2xl font-semibold text-gray-900 mb-4">{{ __('Working Hours') }}</h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-gray-600">
                    @foreach($workingHours as $slot)
                        <p><span class="font-semibold text-gray-900">{{ $slot['day'] }}:</span> {{ $slot['hours'] }}</p>
                    @endforeach
                </div>
            </div>

            <div class="border border-gray-100 rounded-2xl p-6 bg-blue-50/60">
                <h3 class="text-2xl font-semibold text-gray-900 mb-4">{{ __('Stay Safe from Job Scams') }}</h3>
                <p class="text-gray-600 mb-4">{{ __('PlacemeNet is committed to worker protection. Follow these rules and share them with your friends and family applying overseas.') }}</p>
                <div class="space-y-3 text-gray-700">
                    <div>
                        <h4 class="font-semibold text-gray-900">{{ __('PlacemeNet is 100% free') }}</h4>
                        <p>{{ __('We never charge registration fees, sell visas, or take worker commission. Anyone asking for money in our name is a scam.') }}</p>
                    </div>
                    <div>
                        <h4 class="font-semibold text-gray-900">{{ __('Never pay for a job') }}</h4>
                        <p>{{ __('Do not send money via cash, bank, Easypaisa, JazzCash, WhatsApp, or crypto. Genuine employers handle costs legally.') }}</p>
                    </div>
                    <div>
                        <h4 class="font-semibold text-gray-900">{{ __('Verify the employer') }}</h4>
                        <p>{{ __('Collect a written offer, company license, visa document, and detailed contract before you travel. Contact us if anything looks suspicious.') }}</p>
                    </div>
                    <div>
                        <h4 class="font-semibold text-gray-900">{{ __('Official communication only') }}</h4>
                        <p>{{ __('PlacemeNet does not operate via TikTok, Telegram, or random WhatsApp agents. Trust only @placemenet.net emails or the website chat.') }}</p>
                    </div>
                </div>
                <p class="mt-4 text-sm text-gray-600">{!! __('Feel unsafe? Email :support or :legal. We block offenders and report them to authorities.', [
                    'support' => '<a href="mailto:'.$supportEmail.'" class="text-blue-600 font-semibold">'.$supportEmail.'</a>',
                    'legal' => '<a href="mailto:'.$legalEmail.'" class="text-blue-600 font-semibold">'.$legalEmail.'</a>',
                ]) !!}</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="rounded-2xl border border-gray-100 p-6">
                    <h3 class="text-xl font-bold text-gray-900 mb-2">{{ __('Worker Dashboard Highlights') }}</h3>
                    <ul class="space-y-2 text-gray-600">
                        <li>✅ {{ __('Apply for overseas jobs and track every application.') }}</li>
                        <li>✅ {{ __('Complete your profile with experience, skills, passport, and preferred countries.') }}</li>
                        <li>✅ {{ __('Receive interview calls, employer messages, and safety alerts reminding you PlacemeNet is always free.') }}</li>
                        <li>✅ {{ __('Manage account settings—update phone/email or delete your account anytime.') }}</li>
                    </ul>
                </div>
                <div class="rounded-2xl border border-gray-100 p-6">
                    <h3 class="text-xl font-bold text-gray-900 mb-2">{{ __('Employer Dashboard Promise') }}</h3>
                    <ul class="space-y-2 text-gray-600">
                        <li>✅ {{ __('Post jobs for free in Greece or Albania and get unlimited applications.') }}</li>
                        <li>✅ {{ __('Review skills, shortlist candidates, and message workers directly.') }}</li>
                        <li>✅ {{ __('Keep hiring transparent—no fake jobs, no illegal recruitment fees, and full compliance with labor laws.') }}</li>
                        <li>✅ {{ __('Violations lead to permanent bans because we protect both workers and reputable employers.') }}</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
@php
    $orgSchema = [
        '@context' => 'https://schema.org',
        '@type' => 'Organization',
        'name' => config('app.name'),
        'url' => config('app.url'),
        'email' => $supportEmail,
        'contactPoint' => [
            '@type' => 'ContactPoint',
            'contactType' => 'customer support',
            'email' => $supportEmail,
            'availableLanguage' => ['en', 'es', 'el', 'pt', 'sq'],
        ],
        'sameAs' => array_filter([
            $whatsappLink,
        ]),
        'logo' => asset('assets/images/logo.jpg'),
    ];

    $faqSchema = [
        '@context' => 'https://schema.org',
        '@type' => 'FAQPage',
        'mainEntity' => [
            [
                '@type' => 'Question',
                'name' => 'Is PlaceMeNet free for job seekers?',
                'acceptedAnswer' => [
                    '@type' => 'Answer',
                    'text' => 'Yes. PlaceMeNet is 100% free for job seekers; we never charge registration fees or commission.',
                ],
            ],
            [
                '@type' => 'Question',
                'name' => 'How do I stay safe from job scams?',
                'acceptedAnswer' => [
                    '@type' => 'Answer',
                    'text' => 'Never pay for a job, verify the employer, use official communication only, and contact support if anything looks suspicious.',
                ],
            ],
            [
                '@type' => 'Question',
                'name' => 'Can employers post jobs in Greece or Albania for free?',
                'acceptedAnswer' => [
                    '@type' => 'Answer',
                    'text' => 'Yes. Employers can post jobs for free, review applicants, and message candidates directly.',
                ],
            ],
        ],
    ];
@endphp
<script type="application/ld+json">
{!! json_encode($orgSchema, JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT) !!}
</script>
<script type="application/ld+json">
{!! json_encode($faqSchema, JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT) !!}
</script>
@endpush
@endsection
