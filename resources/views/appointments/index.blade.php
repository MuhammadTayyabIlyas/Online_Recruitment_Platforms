@extends('layouts.app')
@section('title', 'Book a Consultation')
@section('meta_description', 'Book a consultation with PlaceMeNet experts. Career coaching, CV review, immigration advice, and more.')

@section('content')
<div class="min-h-screen bg-gradient-to-b from-slate-50 to-white py-16">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        {{-- Header --}}
        <div class="text-center mb-12">
            <h1 class="text-4xl font-bold text-gray-900 mb-4">Book a Consultation</h1>
            <p class="text-lg text-gray-600 max-w-2xl mx-auto">Choose a service to get started. Our experts are here to help you with career guidance, document review, immigration advice, and more.</p>
        </div>

        {{-- Consultation Type Cards --}}
        @if($types->isEmpty())
            <div class="text-center py-12">
                <p class="text-gray-500">No consultation types are currently available. Please check back later.</p>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($types as $type)
                <a href="{{ route('appointments.book', $type) }}"
                   class="group bg-white rounded-xl shadow-sm border border-gray-200 hover:shadow-lg hover:border-{{ $type->color }}-300 transition-all duration-200 overflow-hidden">
                    <div class="h-2 bg-{{ $type->color }}-500"></div>
                    <div class="p-6">
                        <h3 class="text-xl font-semibold text-gray-900 group-hover:text-{{ $type->color }}-600 transition-colors mb-2">{{ $type->name }}</h3>
                        @if($type->description)
                            <p class="text-gray-600 text-sm mb-4 line-clamp-2">{{ $type->description }}</p>
                        @endif
                        <div class="flex items-center justify-between text-sm">
                            <div class="flex items-center space-x-3 text-gray-500">
                                <span class="flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    {{ $type->formatted_duration }}
                                </span>
                                @if($type->allows_online)
                                    <span class="flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                                        </svg>
                                        Online
                                    </span>
                                @endif
                            </div>
                            <span class="font-semibold {{ $type->is_free ? 'text-green-600' : 'text-gray-900' }}">
                                {{ $type->formatted_price }}
                            </span>
                        </div>
                    </div>
                </a>
                @endforeach
            </div>
        @endif
    </div>
</div>
@endsection
