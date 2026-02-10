<div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
    <h2 class="text-xl font-semibold text-gray-900 mb-6">Select Date & Time</h2>

    {{-- Calendar Navigation --}}
    <div class="flex items-center justify-between mb-4">
        <button wire:click="previousMonth" class="p-2 rounded-lg hover:bg-gray-100 transition text-gray-600">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
        </button>
        <h3 class="text-lg font-semibold text-gray-900">{{ $monthLabel }}</h3>
        <button wire:click="nextMonth" class="p-2 rounded-lg hover:bg-gray-100 transition text-gray-600">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
            </svg>
        </button>
    </div>

    {{-- Calendar Grid --}}
    <div class="grid grid-cols-7 gap-1 mb-6">
        {{-- Day headers --}}
        @foreach(['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'] as $dayName)
            <div class="text-center text-xs font-medium text-gray-500 py-2">{{ $dayName }}</div>
        @endforeach

        {{-- Calendar days --}}
        @foreach($calendarDays as $cell)
            @if($cell === null)
                <div class="aspect-square"></div>
            @else
                @if($cell['available'])
                    <button wire:click="selectDate('{{ $cell['date'] }}')"
                            class="aspect-square flex flex-col items-center justify-center rounded-lg text-sm transition-all
                            {{ $cell['selected']
                                ? 'bg-indigo-600 text-white font-semibold shadow-md'
                                : 'bg-indigo-50 text-indigo-700 hover:bg-indigo-100 font-medium cursor-pointer' }}">
                        <span>{{ $cell['day'] }}</span>
                        <span class="text-[10px] {{ $cell['selected'] ? 'text-indigo-200' : 'text-indigo-400' }}">{{ $cell['slots_count'] }} slots</span>
                    </button>
                @else
                    <div class="aspect-square flex items-center justify-center rounded-lg text-sm text-gray-300">
                        {{ $cell['day'] }}
                    </div>
                @endif
            @endif
        @endforeach
    </div>

    {{-- No availability message --}}
    @if(empty($availableDates))
        <div class="bg-amber-50 border border-amber-200 rounded-lg p-4 mb-6 text-center">
            <svg class="w-8 h-8 text-amber-400 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <p class="text-amber-800 font-medium">No available dates this month</p>
            <p class="text-amber-600 text-sm mt-1">Try navigating to the next month, or contact us for assistance.</p>
        </div>
    @endif

    {{-- Time Slots --}}
    @if($selectedDate)
        <div class="border-t border-gray-200 pt-6">
            <h3 class="text-md font-semibold text-gray-900 mb-3">
                Available Times for {{ \Carbon\Carbon::parse($selectedDate)->format('l, F j, Y') }}
            </h3>

            @if(empty($availableSlots))
                <p class="text-gray-500 text-sm">No available slots for this date.</p>
            @else
                <div class="grid grid-cols-3 sm:grid-cols-4 md:grid-cols-6 gap-2">
                    @foreach($availableSlots as $slot)
                        <button
                            wire:click="selectSlot('{{ $slot['start'] }}', '{{ $slot['end'] }}')"
                            x-on:click="$dispatch('slot-selected', { date: '{{ $selectedDate }}', start: '{{ $slot['start'] }}', end: '{{ $slot['end'] }}' })"
                            class="py-2.5 px-3 rounded-lg text-sm font-medium transition-all text-center
                            {{ $selectedSlotStart === $slot['start']
                                ? 'bg-indigo-600 text-white shadow-md'
                                : 'bg-gray-100 text-gray-700 hover:bg-indigo-50 hover:text-indigo-700' }}">
                            {{ $slot['start'] }}
                        </button>
                    @endforeach
                </div>
            @endif
        </div>
    @endif

    {{-- Loading indicator --}}
    <div wire:loading class="flex items-center justify-center py-4">
        <svg class="animate-spin h-5 w-5 text-indigo-600" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
        </svg>
        <span class="ml-2 text-sm text-gray-500">Loading...</span>
    </div>
</div>
