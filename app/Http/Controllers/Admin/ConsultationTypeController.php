<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ConsultationType;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ConsultationTypeController extends Controller
{
    public function index()
    {
        $types = ConsultationType::ordered()->get();
        return view('admin.consultation-types.index', compact('types'));
    }

    public function create()
    {
        return view('admin.consultation-types.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'icon' => 'nullable|string|max:255',
            'color' => 'nullable|string|max:20',
            'duration_minutes' => 'required|integer|min:10|max:480',
            'buffer_minutes' => 'required|integer|min:0|max:60',
            'price' => 'required|numeric|min:0',
            'is_free' => 'boolean',
            'allows_online' => 'boolean',
            'allows_in_person' => 'boolean',
            'sort_order' => 'integer|min:0',
            'max_advance_days' => 'integer|min:1|max:365',
        ]);

        $validated['slug'] = Str::slug($validated['name']);
        $validated['is_free'] = $request->boolean('is_free');
        $validated['allows_online'] = $request->boolean('allows_online');
        $validated['allows_in_person'] = $request->boolean('allows_in_person');
        $validated['currency'] = config('appointments.currency', 'EUR');

        // Ensure unique slug
        $baseSlug = $validated['slug'];
        $counter = 1;
        while (ConsultationType::where('slug', $validated['slug'])->exists()) {
            $validated['slug'] = $baseSlug . '-' . $counter++;
        }

        ConsultationType::create($validated);

        return redirect()->route('admin.consultation-types.index')
            ->with('success', 'Consultation type created successfully.');
    }

    public function edit(ConsultationType $consultationType)
    {
        return view('admin.consultation-types.edit', ['type' => $consultationType]);
    }

    public function update(Request $request, ConsultationType $consultationType)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'icon' => 'nullable|string|max:255',
            'color' => 'nullable|string|max:20',
            'duration_minutes' => 'required|integer|min:10|max:480',
            'buffer_minutes' => 'required|integer|min:0|max:60',
            'price' => 'required|numeric|min:0',
            'is_free' => 'boolean',
            'allows_online' => 'boolean',
            'allows_in_person' => 'boolean',
            'sort_order' => 'integer|min:0',
            'max_advance_days' => 'integer|min:1|max:365',
        ]);

        $validated['is_free'] = $request->boolean('is_free');
        $validated['allows_online'] = $request->boolean('allows_online');
        $validated['allows_in_person'] = $request->boolean('allows_in_person');

        $consultationType->update($validated);

        return redirect()->route('admin.consultation-types.index')
            ->with('success', 'Consultation type updated successfully.');
    }

    public function destroy(ConsultationType $consultationType)
    {
        $consultationType->delete();

        return redirect()->route('admin.consultation-types.index')
            ->with('success', 'Consultation type deleted successfully.');
    }

    public function toggleStatus(ConsultationType $consultationType)
    {
        $consultationType->update(['is_active' => !$consultationType->is_active]);

        return redirect()->route('admin.consultation-types.index')
            ->with('success', 'Status updated successfully.');
    }
}
