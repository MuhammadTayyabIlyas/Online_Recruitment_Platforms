<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AppointmentBlock;
use App\Models\AppointmentSchedule;
use Illuminate\Http\Request;

class AppointmentScheduleController extends Controller
{
    public function index()
    {
        $schedules = AppointmentSchedule::orderBy('day_of_week')->orderBy('start_time')->get();
        $blocks = AppointmentBlock::orderBy('date')->where('date', '>=', now()->toDateString())->get();

        return view('admin.appointment-schedule.index', compact('schedules', 'blocks'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'day_of_week' => 'required|integer|min:0|max:6',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'office_key' => 'nullable|string|max:50',
        ]);

        AppointmentSchedule::create($validated);

        return redirect()->route('admin.appointment-schedule.index')
            ->with('success', 'Schedule slot added successfully.');
    }

    public function update(Request $request, AppointmentSchedule $schedule)
    {
        $validated = $request->validate([
            'day_of_week' => 'required|integer|min:0|max:6',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'office_key' => 'nullable|string|max:50',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->boolean('is_active');
        $schedule->update($validated);

        return redirect()->route('admin.appointment-schedule.index')
            ->with('success', 'Schedule updated successfully.');
    }

    public function destroy(AppointmentSchedule $schedule)
    {
        $schedule->delete();

        return redirect()->route('admin.appointment-schedule.index')
            ->with('success', 'Schedule slot removed successfully.');
    }

    public function storeBlock(Request $request)
    {
        $validated = $request->validate([
            'date' => 'required|date|after_or_equal:today',
            'type' => 'required|in:block,override',
            'start_time' => 'nullable|required_if:type,override|date_format:H:i',
            'end_time' => 'nullable|required_if:type,override|date_format:H:i|after:start_time',
            'reason' => 'nullable|string|max:255',
        ]);

        AppointmentBlock::create($validated);

        return redirect()->route('admin.appointment-schedule.index')
            ->with('success', ($validated['type'] === 'block' ? 'Date blocked' : 'Override added') . ' successfully.');
    }

    public function destroyBlock(AppointmentBlock $block)
    {
        $block->delete();

        return redirect()->route('admin.appointment-schedule.index')
            ->with('success', 'Block/override removed successfully.');
    }
}
