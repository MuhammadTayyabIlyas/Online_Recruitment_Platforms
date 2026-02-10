@extends('layouts.admin')
@section('title', 'Appointments')
@section('page-title', 'Appointments')

@section('content')
<div class="max-w-7xl mx-auto">
    {{-- Header --}}
    <div class="flex flex-wrap justify-between items-center mb-6 gap-3">
        <p class="text-sm text-gray-500">Manage consultation appointments</p>
        <div class="flex space-x-2">
            <a href="{{ route('admin.appointments.calendar') }}"
               class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                Calendar View
            </a>
            <a href="{{ route('admin.appointments.export', request()->query()) }}"
               class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-sm text-white hover:bg-green-700">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                Export CSV
            </a>
        </div>
    </div>

    {{-- Statistics Cards --}}
    <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-7 gap-4 mb-6">
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4">
            <div class="text-sm text-gray-500">Total</div>
            <div class="text-2xl font-bold text-gray-900">{{ number_format($stats['total']) }}</div>
        </div>
        <div class="bg-white rounded-lg shadow-sm border border-indigo-200 p-4 bg-indigo-50">
            <div class="text-sm text-indigo-600">Today</div>
            <div class="text-2xl font-bold text-indigo-700">{{ number_format($stats['today']) }}</div>
        </div>
        <div class="bg-white rounded-lg shadow-sm border border-yellow-200 p-4 bg-yellow-50">
            <div class="text-sm text-yellow-600">Pending</div>
            <div class="text-2xl font-bold text-yellow-700">{{ number_format($stats['pending']) }}</div>
        </div>
        <div class="bg-white rounded-lg shadow-sm border border-blue-200 p-4 bg-blue-50">
            <div class="text-sm text-blue-600">Confirmed</div>
            <div class="text-2xl font-bold text-blue-700">{{ number_format($stats['confirmed']) }}</div>
        </div>
        <div class="bg-white rounded-lg shadow-sm border border-green-200 p-4 bg-green-50">
            <div class="text-sm text-green-600">Completed</div>
            <div class="text-2xl font-bold text-green-700">{{ number_format($stats['completed']) }}</div>
        </div>
        <div class="bg-white rounded-lg shadow-sm border border-red-200 p-4 bg-red-50">
            <div class="text-sm text-red-600">Cancelled</div>
            <div class="text-2xl font-bold text-red-700">{{ number_format($stats['cancelled']) }}</div>
        </div>
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4">
            <div class="text-sm text-gray-500">No Show</div>
            <div class="text-2xl font-bold text-gray-700">{{ number_format($stats['no_show']) }}</div>
        </div>
    </div>

    {{-- Filters --}}
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-6">
        <form action="{{ route('admin.appointments.index') }}" method="GET">
            <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                    <select name="status" id="status" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        <option value="">All Statuses</option>
                        @foreach(['pending', 'confirmed', 'completed', 'cancelled', 'no_show', 'rescheduled'] as $s)
                            <option value="{{ $s }}" {{ request('status') == $s ? 'selected' : '' }}>{{ ucfirst(str_replace('_', ' ', $s)) }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="type" class="block text-sm font-medium text-gray-700 mb-1">Type</label>
                    <select name="type" id="type" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        <option value="">All Types</option>
                        @foreach($consultationTypes as $ct)
                            <option value="{{ $ct->id }}" {{ request('type') == $ct->id ? 'selected' : '' }}>{{ $ct->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Search</label>
                    <input type="text" name="search" id="search" value="{{ request('search') }}" placeholder="Name, email, ref..."
                           class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                </div>
                <div>
                    <label for="date_from" class="block text-sm font-medium text-gray-700 mb-1">From Date</label>
                    <input type="date" name="date_from" id="date_from" value="{{ request('date_from') }}"
                           class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                </div>
                <div class="flex items-end space-x-2">
                    <div class="flex-1">
                        <label for="date_to" class="block text-sm font-medium text-gray-700 mb-1">To Date</label>
                        <input type="date" name="date_to" id="date_to" value="{{ request('date_to') }}"
                               class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    </div>
                    <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 text-sm font-medium">Filter</button>
                </div>
            </div>
        </form>
    </div>

    {{-- Results Table --}}
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Reference</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Client</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Type</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date & Time</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Format</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($appointments as $appointment)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 text-sm font-mono text-gray-900">{{ $appointment->booking_reference }}</td>
                    <td class="px-6 py-4">
                        <div class="text-sm font-medium text-gray-900">{{ $appointment->booker_name }}</div>
                        <div class="text-xs text-gray-500">{{ $appointment->booker_email }}</div>
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-700">{{ $appointment->consultationType->name ?? '-' }}</td>
                    <td class="px-6 py-4">
                        <div class="text-sm text-gray-900">{{ $appointment->appointment_date->format('M j, Y') }}</div>
                        <div class="text-xs text-gray-500">{{ $appointment->formatted_time }}</div>
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-700">{{ $appointment->meeting_format === 'online' ? 'Online' : 'In-Person' }}</td>
                    <td class="px-6 py-4">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-{{ $appointment->status_color }}-100 text-{{ $appointment->status_color }}-800">
                            {{ $appointment->status_label }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-right text-sm">
                        <a href="{{ route('admin.appointments.show', $appointment) }}" class="text-indigo-600 hover:text-indigo-900">View</a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-6 py-8 text-center text-gray-500">No appointments found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $appointments->withQueryString()->links() }}
    </div>
</div>
@endsection
