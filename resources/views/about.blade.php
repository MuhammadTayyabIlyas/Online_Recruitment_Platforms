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

        <!-- Legal Notice Section -->
        <div class="bg-white rounded-2xl shadow-xl p-6 md:p-8 space-y-6">
            <div class="flex items-center mb-2">
                <div class="w-10 h-10 bg-amber-100 rounded-xl flex items-center justify-center mr-4">
                    <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3"/>
                    </svg>
                </div>
                <h3 class="text-2xl font-semibold text-gray-900">{{ __('General Legal Notice') }}</h3>
            </div>

            <div class="space-y-4 text-gray-600">
                <p>
                    PlaceMeNet is a trade name used by a group of independently registered legal entities operating in different jurisdictions. PlaceMeNet provides independent application support and administrative assistance services. We are not a government authority, law-enforcement body, or issuing authority in any country.
                </p>
                <p>
                    Official certificates, records, or documents referenced on this website are issued solely by the relevant government or public authorities, in accordance with their own laws, rules, and procedures. PlaceMeNet does not issue official certificates and does not guarantee approval, issuance, processing times, or acceptance by any authority.
                </p>
                <p>
                    The legal entity responsible for providing the service depends on the country-specific service page you are viewing. Jurisdiction, applicable law, and the contracting entity are clearly stated on each individual service page.
                </p>
            </div>

            <div class="border-t border-gray-200 pt-6">
                <h4 class="font-semibold text-gray-900 mb-3">{{ __('Jurisdiction Clause') }}</h4>
                <p class="text-gray-600">
                    The applicable legal entity, governing law, and jurisdiction are determined by the specific service page accessed by the user. Users must review the jurisdiction notice on each service page before proceeding.
                </p>
            </div>

            <div class="border-t border-gray-200 pt-6">
                <h4 class="font-semibold text-gray-900 mb-3">{{ __('Our Legal Entities') }}</h4>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="bg-blue-50 rounded-xl p-4 border border-blue-100">
                        <div class="flex items-center mb-2">
                            <span class="text-lg mr-2">🇬🇧</span>
                            <span class="font-semibold text-gray-900">United Kingdom</span>
                        </div>
                        <p class="text-sm text-gray-600">PlaceMeNet Ltd</p>
                        <p class="text-xs text-gray-500 mt-1">Registered in England and Wales</p>
                    </div>
                    <div class="bg-blue-50 rounded-xl p-4 border border-blue-100">
                        <div class="flex items-center mb-2">
                            <span class="text-lg mr-2">🇬🇷</span>
                            <span class="font-semibold text-gray-900">Greece</span>
                        </div>
                        <p class="text-sm text-gray-600">PlaceMeNet IKE</p>
                        <p class="text-xs text-gray-500 mt-1">Ιδιωτική Κεφαλαιουχική Εταιρεία</p>
                    </div>
                    <div class="bg-blue-50 rounded-xl p-4 border border-blue-100">
                        <div class="flex items-center mb-2">
                            <span class="text-lg mr-2">🇵🇹</span>
                            <span class="font-semibold text-gray-900">Portugal</span>
                        </div>
                        <p class="text-sm text-gray-600">PlaceMeNet Portugal</p>
                        <p class="text-xs text-gray-500 mt-1">Operating under Portuguese law</p>
                    </div>
                </div>
            </div>

            <div class="bg-amber-50 rounded-xl p-4 border border-amber-200">
                <p class="text-amber-800 text-sm">
                    <strong>Note:</strong> For specific legal inquiries, please contact <a href="mailto:{{ $legalEmail }}" class="text-amber-700 underline">{{ $legalEmail }}</a>. For service-related questions, refer to the jurisdiction notice on the relevant service page.
                </p>
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
