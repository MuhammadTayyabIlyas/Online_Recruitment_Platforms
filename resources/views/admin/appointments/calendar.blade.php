@extends('layouts.admin')
@section('title', 'Appointment Calendar')
@section('page-title', 'Appointment Calendar')

@section('content')
<div class="max-w-7xl mx-auto">
    <div class="flex items-center justify-between mb-6">
        <a href="{{ route('admin.appointments.index') }}" class="text-sm text-indigo-600 hover:text-indigo-800 flex items-center">
            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
            Back to List
        </a>
        <div class="flex items-center space-x-4">
            <a href="{{ route('admin.appointments.calendar', ['year' => $prevMonth->year, 'month' => $prevMonth->month]) }}"
               class="p-2 rounded-lg hover:bg-gray-100 text-gray-600">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
            </a>
            <h2 class="text-xl font-semibold text-gray-900">{{ $monthLabel }}</h2>
            <a href="{{ route('admin.appointments.calendar', ['year' => $nextMonth->year, 'month' => $nextMonth->month]) }}"
               class="p-2 rounded-lg hover:bg-gray-100 text-gray-600">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </a>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
        <div class="grid grid-cols-7">
            @foreach(['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'] as $day)
                <div class="bg-gray-50 text-center text-xs font-medium text-gray-500 uppercase py-3 border-b border-gray-200">{{ $day }}</div>
            @endforeach

            @php
                $firstDay = $start->copy();
                $startOffset = ($firstDay->dayOfWeek === 0) ? 6 : $firstDay->dayOfWeek - 1;
                $daysInMonth = $firstDay->daysInMonth;
            @endphp

            @for($i = 0; $i < $startOffset; $i++)
                <div class="min-h-[100px] border-b border-r border-gray-100 bg-gray-50"></div>
            @endfor

            @for($d = 1; $d <= $daysInMonth; $d++)
                @php
                    $dateStr = sprintf('%04d-%02d-%02d', $year, $month, $d);
                    $dayAppointments = $appointments[$dateStr] ?? collect();
                    $isToday = $dateStr === now()->format('Y-m-d');
                @endphp
                <div class="min-h-[100px] border-b border-r border-gray-100 p-1 {{ $isToday ? 'bg-indigo-50' : '' }}">
                    <div class="text-xs font-medium {{ $isToday ? 'text-indigo-600' : 'text-gray-500' }} mb-1 p-1">{{ $d }}</div>
                    @foreach($dayAppointments->take(3) as $appt)
                        <a href="{{ route('admin.appointments.show', $appt) }}"
                           class="block text-xs px-1.5 py-0.5 mb-0.5 rounded bg-{{ $appt->status_color }}-100 text-{{ $appt->status_color }}-800 truncate hover:opacity-80">
                            {{ \Carbon\Carbon::parse($appt->start_time)->format('H:i') }} {{ Str::limit($appt->booker_name, 12) }}
                        </a>
                    @endforeach
                    @if($dayAppointments->count() > 3)
                        <p class="text-xs text-gray-400 px-1">+{{ $dayAppointments->count() - 3 }} more</p>
                    @endif
                </div>
            @endfor

            @php $totalCells = $startOffset + $daysInMonth; $remaining = (7 - ($totalCells % 7)) % 7; @endphp
            @for($i = 0; $i < $remaining; $i++)
                <div class="min-h-[100px] border-b border-r border-gray-100 bg-gray-50"></div>
            @endfor
        </div>
    </div>
</div>
@endsection
