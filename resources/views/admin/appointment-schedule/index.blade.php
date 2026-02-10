@extends('layouts.admin')
@section('title', 'Appointment Schedule')
@section('page-title', 'Appointment Schedule')

@section('content')
<div class="max-w-7xl mx-auto space-y-8">

    {{-- Weekly Schedule --}}
    <div>
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-lg font-semibold text-gray-900">Weekly Availability</h2>
        </div>

        <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Day</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Start Time</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">End Time</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($schedules as $schedule)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $schedule->day_name }}</td>
                        <td class="px-6 py-4 text-sm text-gray-700">{{ \Carbon\Carbon::parse($schedule->start_time)->format('H:i') }}</td>
                        <td class="px-6 py-4 text-sm text-gray-700">{{ \Carbon\Carbon::parse($schedule->end_time)->format('H:i') }}</td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $schedule->is_active ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                {{ $schedule->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-right text-sm">
                            <form action="{{ route('admin.appointment-schedule.destroy', $schedule) }}" method="POST" class="inline" onsubmit="return confirm('Remove this schedule slot?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900">Remove</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-8 text-center text-gray-500">No schedule slots configured. Add your first availability window below.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Add Schedule Form --}}
        <div class="mt-4 bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <h3 class="text-sm font-semibold text-gray-900 mb-4">Add Schedule Slot</h3>
            <form action="{{ route('admin.appointment-schedule.store') }}" method="POST">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div>
                        <label for="day_of_week" class="block text-sm font-medium text-gray-700 mb-1">Day</label>
                        <select name="day_of_week" id="day_of_week" required class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            <option value="1">Monday</option>
                            <option value="2">Tuesday</option>
                            <option value="3">Wednesday</option>
                            <option value="4">Thursday</option>
                            <option value="5">Friday</option>
                            <option value="6">Saturday</option>
                            <option value="0">Sunday</option>
                        </select>
                    </div>
                    <div>
                        <label for="start_time" class="block text-sm font-medium text-gray-700 mb-1">Start Time</label>
                        <input type="time" name="start_time" id="start_time" required value="10:00"
                               class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    </div>
                    <div>
                        <label for="end_time" class="block text-sm font-medium text-gray-700 mb-1">End Time</label>
                        <input type="time" name="end_time" id="end_time" required value="18:00"
                               class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    </div>
                    <div class="flex items-end">
                        <button type="submit" class="w-full px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 text-sm font-medium">Add Slot</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- Date Overrides & Blocks --}}
    <div>
        <h2 class="text-lg font-semibold text-gray-900 mb-4">Date Overrides & Blocks</h2>

        <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Type</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Time</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Reason</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($blocks as $block)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $block->date->format('D, M j, Y') }}</td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $block->type === 'block' ? 'bg-red-100 text-red-800' : 'bg-blue-100 text-blue-800' }}">
                                {{ $block->type === 'block' ? 'Blocked' : 'Override' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-700">
                            @if($block->start_time && $block->end_time)
                                {{ \Carbon\Carbon::parse($block->start_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($block->end_time)->format('H:i') }}
                            @else
                                All day
                            @endif
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-500">{{ $block->reason ?? '-' }}</td>
                        <td class="px-6 py-4 text-right text-sm">
                            <form action="{{ route('admin.appointment-schedule.destroy-block', $block) }}" method="POST" class="inline" onsubmit="return confirm('Remove this block/override?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900">Remove</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-8 text-center text-gray-500">No date overrides or blocks configured.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Add Block/Override Form --}}
        <div class="mt-4 bg-white rounded-lg shadow-sm border border-gray-200 p-6" x-data="{ blockType: 'block' }">
            <h3 class="text-sm font-semibold text-gray-900 mb-4">Add Date Block or Override</h3>
            <form action="{{ route('admin.appointment-schedule.store-block') }}" method="POST">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
                    <div>
                        <label for="block_date" class="block text-sm font-medium text-gray-700 mb-1">Date</label>
                        <input type="date" name="date" id="block_date" required min="{{ now()->format('Y-m-d') }}"
                               class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    </div>
                    <div>
                        <label for="block_type" class="block text-sm font-medium text-gray-700 mb-1">Type</label>
                        <select name="type" id="block_type" x-model="blockType" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            <option value="block">Block (day off)</option>
                            <option value="override">Override (custom hours)</option>
                        </select>
                    </div>
                    <div x-show="blockType === 'override'" x-transition>
                        <label for="block_start_time" class="block text-sm font-medium text-gray-700 mb-1">Start Time</label>
                        <input type="time" name="start_time" id="block_start_time" value="10:00"
                               class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    </div>
                    <div x-show="blockType === 'override'" x-transition>
                        <label for="block_end_time" class="block text-sm font-medium text-gray-700 mb-1">End Time</label>
                        <input type="time" name="end_time" id="block_end_time" value="18:00"
                               class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    </div>
                    <div>
                        <label for="block_reason" class="block text-sm font-medium text-gray-700 mb-1">Reason</label>
                        <input type="text" name="reason" id="block_reason" placeholder="e.g. Public Holiday"
                               class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    </div>
                </div>
                <div class="mt-4">
                    <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 text-sm font-medium">Add</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
