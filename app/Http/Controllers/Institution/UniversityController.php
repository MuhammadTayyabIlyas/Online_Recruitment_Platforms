<?php

namespace App\Http\Controllers\Institution;

use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\University;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class UniversityController extends Controller
{
    public function create()
    {
        return view('institution.universities.create', [
            'countries' => Country::orderBy('name')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'country_id' => ['nullable', 'exists:countries,id'],
            'country_name' => ['required_without:country_id', 'string', 'max:255'],
            'website' => ['nullable', 'url', 'max:255'],
        ]);

        $countryId = $data['country_id'] ?? null;

        if (!$countryId && !empty($data['country_name'])) {
            $country = Country::firstOrCreate(
                ['name' => $data['country_name']],
                ['code' => strtoupper(substr($data['country_name'], 0, 3))]
            );
            $countryId = $country->id;
        }

        University::create([
            'name' => $data['name'],
            'country_id' => $countryId,
            'website' => $data['website'] ?? null,
            'logo' => null,
            'slug' => Str::slug($data['name']) . '-' . Str::random(4),
        ]);

        return redirect()->route('institution.programs.create')->with('status', 'Educational institution added. It is now selectable in the dropdown.');
    }
}
