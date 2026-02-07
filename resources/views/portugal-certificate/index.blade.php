@extends('layouts.app')

@section('title', 'Portugal Criminal Record Certificate')
@section('meta_description', 'Apply for Portugal Criminal Record Certificate (Certificado de Registo Criminal) through PlaceMeNet. Fast, reliable service for employment, immigration, and visa purposes.')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-green-50 to-red-50">
    <!-- Hero Section with Portuguese imagery -->
    <div class="relative overflow-hidden">
        <!-- Background image of Lisbon/Portugal -->
        <div class="absolute inset-0">
            <img src="https://images.unsplash.com/photo-1585208798174-6cedd86e019a?auto=format&fit=crop&w=1920&q=80"
                 alt="Lisbon, Portugal - Traditional tram"
                 class="w-full h-full object-cover">
            <div class="absolute inset-0 bg-gradient-to-r from-green-900/90 to-red-800/80"></div>
        </div>

        <!-- Portuguese tiles pattern overlay -->
        <div class="absolute inset-0 opacity-10">
            <svg class="w-full h-full" viewBox="0 0 100 100" preserveAspectRatio="none">
                <pattern id="azulejo" width="20" height="20" patternUnits="userSpaceOnUse">
                    <rect width="20" height="20" fill="none" stroke="white" stroke-width="0.5"/>
                    <circle cx="10" cy="10" r="5" fill="none" stroke="white" stroke-width="0.5"/>
                    <path d="M0 0 L20 20 M20 0 L0 20" stroke="white" stroke-width="0.3"/>
                </pattern>
                <rect width="100" height="100" fill="url(#azulejo)"/>
            </svg>
        </div>

        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 md:py-28">
            <div class="text-center">
                <!-- Portuguese flag colors indicator -->
                <div class="inline-flex items-center px-4 py-2 bg-white/20 backdrop-blur-sm rounded-full text-white text-sm font-medium mb-6">
                    <span class="flex gap-1 mr-2">
                        <span class="w-3 h-2 bg-green-500 rounded-sm"></span>
                        <span class="w-3 h-2 bg-red-500 rounded-sm"></span>
                    </span>
                    Official Document Assistance Service
                </div>

                <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold text-white mb-6">
                    Portugal Criminal Record<br>
                    <span class="text-yellow-300">Certificate Application</span>
                </h1>

                <p class="text-xl text-green-100 max-w-3xl mx-auto mb-8">
                    Get your Certificado de Registo Criminal for employment, immigration, visa applications, and more. We handle the entire process for you.
                </p>

                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="{{ route('portugal-certificate.step', ['step' => 1]) }}"
                       class="inline-flex items-center justify-center px-8 py-4 bg-white text-green-700 font-bold rounded-xl hover:bg-green-50 transition shadow-xl hover:shadow-2xl transform hover:-translate-y-1">
                        <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        Start Application
                    </a>
                    <a href="#how-it-works"
                       class="inline-flex items-center justify-center px-8 py-4 border-2 border-white/50 text-white font-bold rounded-xl hover:bg-white/10 transition">
                        Learn More
                        <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </a>
                    <a href="#legal-notice"
                       class="inline-flex items-center justify-center px-8 py-4 text-white/80 hover:text-white transition">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        Legal Notice
                    </a>
                </div>
            </div>
        </div>

        <!-- Wave decoration -->
        <div class="absolute bottom-0 left-0 right-0">
            <svg viewBox="0 0 1440 120" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M0 120L60 110C120 100 240 80 360 70C480 60 600 60 720 65C840 70 960 80 1080 85C1200 90 1320 90 1380 90L1440 90V120H1380C1320 120 1200 120 1080 120C960 120 840 120 720 120C600 120 480 120 360 120C240 120 120 120 60 120H0Z" fill="#F0FDF4"/>
            </svg>
        </div>
    </div>

    <!-- Features Section -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div class="grid md:grid-cols-3 gap-8">
            <div class="bg-white rounded-2xl p-8 shadow-lg hover:shadow-xl transition border-t-4 border-green-600">
                <div class="w-14 h-14 bg-green-100 rounded-xl flex items-center justify-center mb-6">
                    <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-3">In-Person Processing</h3>
                <p class="text-gray-600">We handle the entire in-person procedure at Portuguese authorities on your behalf.</p>
            </div>

            <div class="bg-white rounded-2xl p-8 shadow-lg hover:shadow-xl transition border-t-4 border-red-600">
                <div class="w-14 h-14 bg-red-100 rounded-xl flex items-center justify-center mb-6">
                    <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-3">Secure & Reliable</h3>
                <p class="text-gray-600">Your documents are handled securely. Official certificate issued by Portuguese authorities.</p>
            </div>

            <div class="bg-white rounded-2xl p-8 shadow-lg hover:shadow-xl transition border-t-4 border-green-600">
                <div class="w-14 h-14 bg-green-100 rounded-xl flex items-center justify-center mb-6">
                    <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"/>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-3">Full Support</h3>
                <p class="text-gray-600">Dedicated support throughout the process. We handle all communication with authorities.</p>
            </div>
        </div>
    </div>

    <!-- Required Documents Section -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div class="bg-white rounded-3xl shadow-xl overflow-hidden">
            <div class="grid lg:grid-cols-2">
                <div class="p-8 lg:p-12">
                    <div class="flex items-center mb-6">
                        <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center mr-4">
                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
                            </svg>
                        </div>
                        <h2 class="text-2xl font-bold text-gray-900">Required Documents</h2>
                    </div>
                    <p class="text-gray-600 mb-6">Please have these documents ready before starting your application:</p>
                    <ul class="space-y-4">
                        <li class="flex items-start">
                            <svg class="w-6 h-6 text-green-500 mt-0.5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <div>
                                <span class="font-semibold text-gray-900">Valid Passport</span>
                                <p class="text-sm text-gray-500">Clear color scan of your passport (data page)</p>
                            </div>
                        </li>
                        <li class="flex items-start">
                            <svg class="w-6 h-6 text-green-500 mt-0.5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <div>
                                <span class="font-semibold text-gray-900">National ID Card</span>
                                <p class="text-sm text-gray-500">Front and back scan of your ID document</p>
                            </div>
                        </li>
                        <li class="flex items-start">
                            <svg class="w-6 h-6 text-green-500 mt-0.5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <div>
                                <span class="font-semibold text-gray-900">Portuguese NIF (Tax Number)</span>
                                <p class="text-sm text-gray-500">Your Portuguese tax identification number if available</p>
                            </div>
                        </li>
                        <li class="flex items-start">
                            <svg class="w-6 h-6 text-green-500 mt-0.5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <div>
                                <span class="font-semibold text-gray-900">Proof of Address</span>
                                <p class="text-sm text-gray-500">Recent utility bill or official document with your address</p>
                            </div>
                        </li>
                    </ul>
                </div>
                <div class="bg-gradient-to-br from-green-600 to-red-600 p-8 lg:p-12 flex items-center justify-center">
                    <div class="text-center text-white">
                        <svg class="w-20 h-20 mx-auto mb-4 opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        <p class="text-lg font-semibold mb-2">All Documents Digital</p>
                        <p class="text-green-200 text-sm">Upload clear scans or photos in JPG, PNG, or PDF format</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Processing Timeline Section -->
    <div class="bg-gray-50 py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-900 mb-4">Processing Timeline</h2>
                <p class="text-gray-600 max-w-2xl mx-auto">This is an in-person procedure. Here's what happens after you submit your application.</p>
            </div>

            <div class="max-w-3xl mx-auto">
                <div class="bg-white rounded-2xl p-8 shadow-lg">
                    <div class="flex items-center mb-6">
                        <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center mr-4">
                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900">In-Person Procedure Steps</h3>
                    </div>
                    <div class="space-y-6">
                        <div class="flex items-start">
                            <div class="w-10 h-10 bg-green-600 text-white rounded-full flex items-center justify-center font-bold mr-4 flex-shrink-0">1</div>
                            <div class="flex-1">
                                <p class="font-medium text-gray-900">Document Verification</p>
                                <p class="text-sm text-gray-500">We review and verify your documents and information</p>
                            </div>
                        </div>
                        <div class="flex items-start">
                            <div class="w-10 h-10 bg-red-600 text-white rounded-full flex items-center justify-center font-bold mr-4 flex-shrink-0">2</div>
                            <div class="flex-1">
                                <p class="font-medium text-gray-900">In-Person Submission</p>
                                <p class="text-sm text-gray-500">Our representative visits DGAJ (Portuguese Justice) on your behalf</p>
                            </div>
                        </div>
                        <div class="flex items-start">
                            <div class="w-10 h-10 bg-green-600 text-white rounded-full flex items-center justify-center font-bold mr-4 flex-shrink-0">3</div>
                            <div class="flex-1">
                                <p class="font-medium text-gray-900">Official Processing</p>
                                <p class="text-sm text-gray-500">Portuguese authorities process your application (timing varies by authority workload)</p>
                            </div>
                        </div>
                        <div class="flex items-start">
                            <div class="w-10 h-10 bg-red-600 text-white rounded-full flex items-center justify-center font-bold mr-4 flex-shrink-0">4</div>
                            <div class="flex-1">
                                <p class="font-medium text-gray-900">Certificate Collection & Delivery</p>
                                <p class="text-sm text-gray-500">We collect your certificate and deliver it to you</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-6 bg-green-50 border border-green-200 rounded-xl p-4">
                    <div class="flex items-start">
                        <svg class="w-5 h-5 text-green-600 mt-0.5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <p class="text-sm text-green-800">
                            <strong>Note:</strong> As this is an in-person procedure that requires physical presence at Portuguese authorities, processing times may vary. We will keep you informed throughout the entire process and provide regular updates on your application status.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Jurisdiction Notice -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="bg-gradient-to-r from-green-50 to-red-50 border border-green-200 rounded-2xl p-6">
            <div class="flex items-start">
                <div class="flex-shrink-0">
                    <svg class="h-6 w-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3"/>
                    </svg>
                </div>
                <div class="ml-4">
                    <h3 class="text-sm font-bold text-green-900 mb-1">Jurisdiction Notice</h3>
                    <p class="text-sm text-green-800">
                        This service is provided by the <strong>PlaceMeNet entity operating in Portugal</strong>. Portuguese law and EU regulations apply to this service.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Service Options Section -->
    <div class="bg-white py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-900 mb-4">Our Service</h2>
                <p class="text-gray-600 max-w-2xl mx-auto">We handle the entire in-person application process on your behalf</p>
            </div>

            <div class="max-w-2xl mx-auto">
                <div class="bg-gradient-to-br from-green-600 to-red-600 rounded-2xl p-8 text-white relative overflow-hidden">
                    <div class="absolute top-4 right-4 bg-white text-green-600 text-xs font-bold px-3 py-1 rounded-full">
                        IN-PERSON SERVICE
                    </div>
                    <div class="text-center">
                        <h3 class="text-2xl font-bold mb-4">Portugal Criminal Record Certificate</h3>
                        <p class="text-green-100 mb-6">This is an in-person procedure that requires physical presence at Portuguese authorities. We handle this on your behalf.</p>

                        <ul class="text-left space-y-3 mb-8 max-w-md mx-auto">
                            <li class="flex items-center">
                                <svg class="w-5 h-5 text-green-300 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                Full application handling
                            </li>
                            <li class="flex items-center">
                                <svg class="w-5 h-5 text-green-300 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                In-person submission on your behalf
                            </li>
                            <li class="flex items-center">
                                <svg class="w-5 h-5 text-green-300 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                Document verification
                            </li>
                            <li class="flex items-center">
                                <svg class="w-5 h-5 text-green-300 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                Dedicated case handler
                            </li>
                            <li class="flex items-center">
                                <svg class="w-5 h-5 text-green-300 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                WhatsApp & Email support
                            </li>
                        </ul>

                        <div class="bg-white/10 rounded-xl p-4 mb-6">
                            <p class="text-sm text-green-100">
                                <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                Processing time varies as this is an in-person procedure. We will keep you updated throughout the process.
                            </p>
                        </div>

                        <div class="bg-white/10 rounded-xl p-4 mb-6">
                            <p class="text-sm text-green-100">
                                <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                Pricing details will be provided after you start your application or via email.
                            </p>
                        </div>

                        <a href="{{ route('portugal-certificate.step', ['step' => 1]) }}"
                           class="inline-flex items-center justify-center px-8 py-4 bg-white text-green-700 font-bold rounded-xl hover:bg-green-50 transition shadow-lg">
                            Start Application
                            <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>

            <p class="text-center text-sm text-gray-500 mt-8">
                Service fees will be communicated during the application process or via email. No payment required to start your application.
            </p>
        </div>
    </div>

    <!-- How It Works -->
    <div id="how-it-works" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-gray-900 mb-4">How It Works</h2>
            <p class="text-gray-600 max-w-2xl mx-auto">Simple 4-step process to get your certificate</p>
        </div>

        <div class="grid md:grid-cols-4 gap-8">
            <div class="text-center">
                <div class="w-16 h-16 bg-green-600 text-white rounded-full flex items-center justify-center text-2xl font-bold mx-auto mb-4">1</div>
                <h3 class="font-bold text-gray-900 mb-2">Fill Application</h3>
                <p class="text-gray-600 text-sm">Complete the online form with your personal details</p>
            </div>
            <div class="text-center">
                <div class="w-16 h-16 bg-red-600 text-white rounded-full flex items-center justify-center text-2xl font-bold mx-auto mb-4">2</div>
                <h3 class="font-bold text-gray-900 mb-2">Upload Documents</h3>
                <p class="text-gray-600 text-sm">Upload your passport and supporting documents</p>
            </div>
            <div class="text-center">
                <div class="w-16 h-16 bg-green-600 text-white rounded-full flex items-center justify-center text-2xl font-bold mx-auto mb-4">3</div>
                <h3 class="font-bold text-gray-900 mb-2">Make Payment</h3>
                <p class="text-gray-600 text-sm">Pay the service fee via bank transfer</p>
            </div>
            <div class="text-center">
                <div class="w-16 h-16 bg-red-600 text-white rounded-full flex items-center justify-center text-2xl font-bold mx-auto mb-4">4</div>
                <h3 class="font-bold text-gray-900 mb-2">Receive Certificate</h3>
                <p class="text-gray-600 text-sm">Get your official certificate delivered</p>
            </div>
        </div>
    </div>

    <!-- Refund & Cancellation Policy -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-8">
        <div class="bg-gradient-to-r from-amber-50 to-orange-50 border border-amber-200 rounded-2xl p-6">
            <div class="flex items-start">
                <div class="flex-shrink-0">
                    <svg class="h-6 w-6 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div class="ml-4">
                    <h3 class="text-sm font-bold text-amber-900 mb-2">Refund & Cancellation Policy</h3>
                    <div class="text-sm text-amber-800 space-y-2">
                        <p><strong>Full Refund:</strong> Cancel within 24 hours of payment if we haven't started processing your application.</p>
                        <p><strong>Partial Refund (50%):</strong> Cancel after 24 hours but before submission to Portuguese authorities.</p>
                        <p><strong>No Refund:</strong> Once your application has been submitted to DGAJ, no refund is possible as official fees are non-recoverable.</p>
                        <p class="text-amber-600 text-xs mt-2">* All refund requests must be made in writing to support@placemenet.net</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Need Help Section -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div class="bg-gradient-to-r from-green-600 to-red-600 rounded-3xl p-8 md:p-12 text-white">
            <div class="grid md:grid-cols-2 gap-8 items-center">
                <div>
                    <h2 class="text-2xl md:text-3xl font-bold mb-4">Need Help?</h2>
                    <p class="text-green-100 mb-6">
                        Have questions about the Portugal Criminal Record Certificate process? Our team is here to help you in Portuguese, English, and other languages.
                    </p>
                    <div class="space-y-4">
                        <div class="flex items-center">
                            <svg class="w-6 h-6 text-green-200 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <span class="text-green-100">Mon - Fri: 9:00 AM - 6:00 PM (WET)</span>
                        </div>
                        <div class="flex items-center">
                            <svg class="w-6 h-6 text-green-200 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                            <span class="text-green-100">support@placemenet.net</span>
                        </div>
                    </div>
                </div>
                <div class="flex flex-col sm:flex-row gap-4 justify-center md:justify-end">
                    <a href="https://wa.me/351920385866?text={{ urlencode('Hello, I\'m interested in getting a Portugal Criminal Record Certificate (Certificado de Registo Criminal). Can you please help me with the application process?') }}" target="_blank" rel="noopener"
                       class="inline-flex items-center justify-center px-6 py-4 bg-green-500 hover:bg-green-400 text-white font-bold rounded-xl transition shadow-lg">
                        <svg class="w-6 h-6 mr-2" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                        </svg>
                        WhatsApp Portugal
                    </a>
                    <a href="tel:+351920385866"
                       class="inline-flex items-center justify-center px-6 py-4 bg-white/20 hover:bg-white/30 text-white font-bold rounded-xl transition">
                        <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                        </svg>
                        +351 920 385 866
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Legal Notice Section -->
    <div id="legal-notice" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div class="bg-white rounded-3xl shadow-xl p-8 md:p-12">
            <div class="flex items-center mb-8">
                <div class="w-12 h-12 bg-amber-100 rounded-xl flex items-center justify-center mr-4">
                    <svg class="w-6 h-6 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                    </svg>
                </div>
                <h2 class="text-2xl md:text-3xl font-bold text-gray-900">Important Legal Notice</h2>
            </div>

            <p class="text-gray-600 mb-8 text-lg">
                <strong>PlaceMeNet Disclaimer for Portugal Criminal Record Certificate Assistance</strong>
            </p>

            <div class="space-y-6 text-gray-700">
                <div class="border-l-4 border-green-600 pl-4">
                    <h3 class="font-semibold text-gray-900 mb-2">1. Independent Service Provider</h3>
                    <p>PlaceMeNet ("we", "us", "our") is an independent service provider assisting individuals with document preparation and submission guidance in relation to Criminal Record Certificates (Certificado de Registo Criminal) requested from Portuguese authorities. We are not a government agency, regulator, or part of any Portuguese governmental body, and our services are not required to obtain a Portuguese Criminal Record Certificate.</p>
                </div>

                <div class="border-l-4 border-red-600 pl-4">
                    <h3 class="font-semibold text-gray-900 mb-2">2. No Guarantee of Outcome</h3>
                    <p>PlaceMeNet does not guarantee that any application for a Criminal Record Certificate will be accepted, approved, processed, or issued by the Direção-Geral da Administração da Justiça (DGAJ), the Portuguese Ministry of Justice, or any other Portuguese authority. All such decisions are made solely by the relevant issuing authority.</p>
                </div>

                <div class="border-l-4 border-green-600 pl-4">
                    <h3 class="font-semibold text-gray-900 mb-2">3. Portuguese Authority Terms & Conditions</h3>
                    <p>Users acknowledge that Portuguese law and the terms set by the Direção-Geral da Administração da Justiça govern the issuance of Criminal Record Certificates. These include requirements relating to application accuracy, applicant identity, supporting documentation, and processing rules. Users must comply with all applicable Portuguese laws and regulations.</p>
                </div>

                <div class="border-l-4 border-red-600 pl-4">
                    <h3 class="font-semibold text-gray-900 mb-2">4. Applicant Responsibility</h3>
                    <p>You are responsible for providing accurate and complete information, including identity documentation, personal details, and any required supporting documents. PlaceMeNet will assist with submission support, but you retain responsibility for your application and compliance with all legal requirements.</p>
                </div>

                <div class="border-l-4 border-green-600 pl-4">
                    <h3 class="font-semibold text-gray-900 mb-2">5. Data Protection & Confidentiality</h3>
                    <p>Any personal data you provide to PlaceMeNet will be processed in accordance with our <a href="{{ route('privacy') }}" class="text-green-600 hover:underline">Privacy Policy</a> and applicable data protection laws, including GDPR. PlaceMeNet does not share your data with Portuguese authorities without your consent, except where required to complete an application or where required by law.</p>
                </div>

                <div class="border-l-4 border-red-600 pl-4">
                    <h3 class="font-semibold text-gray-900 mb-2">6. No Legal Advice</h3>
                    <p>PlaceMeNet does not provide legal advice. If you require legal interpretation of Portuguese laws, immigration rules, apostille/legalisation requirements, or any other legal matters, you should seek qualified legal counsel.</p>
                </div>

                <div class="border-l-4 border-green-600 pl-4">
                    <h3 class="font-semibold text-gray-900 mb-2">7. Fees and Payments</h3>
                    <p>PlaceMeNet charges fees for its services separately from any official government fees. You acknowledge that any official fees charged by Portuguese authorities are not included in PlaceMeNet's service fees, unless explicitly stated.</p>
                </div>

                <div class="border-l-4 border-red-600 pl-4">
                    <h3 class="font-semibold text-gray-900 mb-2">8. Third-Party Services</h3>
                    <p>If PlaceMeNet refers you to any third-party providers (for translations, document legalisation, courier services, etc.), PlaceMeNet is not responsible for the performance, conduct, or pricing of those third parties.</p>
                </div>

                <div class="border-l-4 border-green-600 pl-4">
                    <h3 class="font-semibold text-gray-900 mb-2">9. Limitation of Liability</h3>
                    <p>To the maximum extent permitted by law, PlaceMeNet's total liability to you for all claims arising out of or relating to our services is limited to the total fees you have paid to PlaceMeNet for those services.</p>
                </div>
            </div>

            <div class="mt-8 p-4 bg-amber-50 rounded-xl border border-amber-200">
                <p class="text-amber-800 text-sm">
                    <strong>By using our services, you acknowledge that you have read, understood, and agree to this disclaimer.</strong>
                </p>
            </div>
        </div>
    </div>

    <!-- CTA Section -->
    <div class="bg-gradient-to-r from-green-600 to-red-600 py-16">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-3xl font-bold text-white mb-4">Ready to Apply?</h2>
            <p class="text-green-100 text-lg mb-8">Start your application now and get your Portugal Criminal Record Certificate</p>
            <a href="{{ route('portugal-certificate.step', ['step' => 1]) }}"
               class="inline-flex items-center px-8 py-4 bg-white text-green-700 font-bold rounded-xl hover:bg-green-50 transition shadow-xl">
                Start Application Now
                <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                </svg>
            </a>
        </div>
    </div>
</div>
@endsection
