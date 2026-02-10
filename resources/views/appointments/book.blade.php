@extends('layouts.app')
@section('title', 'Book ' . $type->name)

@section('content')
<div class="min-h-screen bg-gradient-to-b from-slate-50 to-white py-12">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        {{-- Header --}}
        <div class="mb-8">
            <a href="{{ route('appointments.index') }}" class="text-sm text-indigo-600 hover:text-indigo-800 flex items-center mb-4">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
                Back to Consultations
            </a>
            <h1 class="text-3xl font-bold text-gray-900 mb-2">{{ $type->name }}</h1>
            @if($type->description)
                <p class="text-gray-600">{{ $type->description }}</p>
            @endif
            <div class="flex items-center space-x-4 mt-3 text-sm text-gray-500">
                <span class="flex items-center">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    {{ $type->formatted_duration }}
                </span>
                <span class="font-semibold {{ $type->is_free ? 'text-green-600' : 'text-gray-900' }}">{{ $type->formatted_price }}</span>
            </div>
        </div>

        @if($errors->any())
            <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded">
                @foreach($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        {{-- Slot Picker + Booking Form --}}
        @livewire('appointment-slot-picker', ['consultationTypeId' => $type->id])

        {{-- Booking form (shown after slot is selected, handled via Alpine) --}}
        <div id="booking-form" class="mt-8 bg-white rounded-xl shadow-sm border border-gray-200 p-6"
             x-data="bookingForm()" x-show="showForm" x-cloak x-transition>
            <h2 class="text-xl font-semibold text-gray-900 mb-6">Your Details</h2>
            <form action="{{ route('appointments.store', $type) }}" method="POST">
                @csrf
                <input type="hidden" name="appointment_date" :value="selectedDate">
                <input type="hidden" name="start_time" :value="selectedStart">
                <input type="hidden" name="end_time" :value="selectedEnd">

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="booker_name" class="block text-sm font-medium text-gray-700 mb-1">Full Name *</label>
                        <input type="text" name="booker_name" id="booker_name" required
                               value="{{ auth()->check() ? auth()->user()->name : old('booker_name') }}"
                               class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    </div>
                    <div>
                        <label for="booker_email" class="block text-sm font-medium text-gray-700 mb-1">Email *</label>
                        <input type="email" name="booker_email" id="booker_email" required
                               value="{{ auth()->check() ? auth()->user()->email : old('booker_email') }}"
                               class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    </div>
                    <div>
                        <label for="booker_phone" class="block text-sm font-medium text-gray-700 mb-1">Phone</label>
                        <input type="text" name="booker_phone" id="booker_phone"
                               value="{{ auth()->check() ? auth()->user()->phone : old('booker_phone') }}"
                               class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    </div>
                    <div>
                        <label for="meeting_format" class="block text-sm font-medium text-gray-700 mb-1">Meeting Format *</label>
                        <select name="meeting_format" id="meeting_format" required x-model="meetingFormat"
                                class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            @if($type->allows_online)
                                <option value="online">Online Meeting</option>
                            @endif
                            @if($type->allows_in_person)
                                <option value="in_person">In-Person at Office</option>
                            @endif
                        </select>
                    </div>
                </div>

                {{-- Office Selection (shown when in_person is selected) --}}
                <div x-show="meetingFormat === 'in_person'" x-transition class="mt-4">
                    <label for="office_key" class="block text-sm font-medium text-gray-700 mb-1">Select Office *</label>
                    <select name="office_key" id="office_key"
                            class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        @foreach(config('placemenet.offices', []) as $office)
                            <option value="{{ $office['key'] }}">{{ $office['label'] }} - {{ $office['address'] }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mt-4">
                    <label for="notes" class="block text-sm font-medium text-gray-700 mb-1">Notes (optional)</label>
                    <textarea name="notes" id="notes" rows="3"
                              class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                              placeholder="Anything you'd like us to know before the meeting...">{{ old('notes') }}</textarea>
                </div>

                <div class="mt-6">
                    <button type="submit"
                            class="w-full md:w-auto px-8 py-3 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 font-semibold transition-colors">
                        {{ $type->is_free ? 'Confirm Booking' : 'Proceed to Payment (' . $type->formatted_price . ')' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function bookingForm() {
        return {
            showForm: false,
            selectedDate: '',
            selectedStart: '',
            selectedEnd: '',
            meetingFormat: '{{ $type->allows_online ? "online" : "in_person" }}',
            init() {
                window.addEventListener('slot-selected', (e) => {
                    this.selectedDate = e.detail.date;
                    this.selectedStart = e.detail.start;
                    this.selectedEnd = e.detail.end;
                    this.showForm = true;
                    this.$nextTick(() => {
                        document.getElementById('booking-form').scrollIntoView({ behavior: 'smooth', block: 'start' });
                    });
                });
            }
        };
    }
</script>
@endpush
@endsection
