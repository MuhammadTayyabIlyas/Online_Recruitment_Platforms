<?php

namespace App\Http\Controllers\Employer;

use App\Http\Controllers\Controller;
use App\Http\Requests\CompanyRequest;
use App\Models\Company;
use App\Models\Industry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CompanyController extends Controller
{
    public function index()
    {
        $company = auth()->user()->company;
        return view('employer.company.show', compact('company'));
    }

    public function create()
    {
        if (auth()->user()->company) {
            return redirect()->route('employer.company.edit');
        }
        $industries = Industry::active()->ordered()->get();
        return view('employer.company.create', compact('industries'));
    }

    public function store(CompanyRequest $request)
    {
        // Prevent creating duplicate companies
        if (auth()->user()->company) {
            return redirect()->route('employer.company.edit')
                ->with('info', 'You already have a company profile. You can edit it here.');
        }

        $data = $request->validated();
        $data['user_id'] = auth()->id();
        $data['uuid'] = Str::uuid();
        
        // Generate unique slug
        $slug = Str::slug($data['company_name']);
        $originalSlug = $slug;
        $count = 1;
        while (Company::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $count;
            $count++;
        }
        $data['slug'] = $slug;

        if ($request->hasFile('logo')) {
            $data['logo'] = $request->file('logo')->store('companies/logos', 'public');
        }

        $company = Company::create($data);

        return redirect()->route('employer.company.show')
            ->with('success', 'Company profile created successfully!');
    }

    public function show()
    {
        $company = auth()->user()->company;
        if (!$company) {
            return redirect()->route('employer.company.create');
        }
        return view('employer.company.show', compact('company'));
    }

    public function edit()
    {
        $company = auth()->user()->company;
        if (!$company) {
            return redirect()->route('employer.company.create');
        }
        $industries = Industry::active()->ordered()->get();
        return view('employer.company.edit', compact('company', 'industries'));
    }

    public function update(CompanyRequest $request)
    {
        $company = auth()->user()->company;
        $data = $request->validated();

        if ($request->hasFile('logo')) {
            if ($company->logo) {
                Storage::disk('public')->delete($company->logo);
            }
            $data['logo'] = $request->file('logo')->store('companies/logos', 'public');
        }

        $company->update($data);

        return redirect()->route('employer.company.show')
            ->with('success', 'Company profile updated successfully!');
    }

    public function uploadMedia(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:jpg,jpeg,png,gif,mp4,pdf|max:10240',
            'type' => 'required|in:image,video,document',
        ]);

        $company = auth()->user()->company;
        $file = $request->file('file');
        $path = $file->store('companies/media/' . $company->id, 'public');

        $company->media()->create([
            'type' => $request->type,
            'file_path' => $path,
            'file_name' => $file->getClientOriginalName(),
            'file_type' => $file->getMimeType(),
            'file_size' => $file->getSize(),
        ]);

        return response()->json(['success' => true, 'path' => $path]);
    }

    public function requestVerification(Request $request)
    {
        $request->validate([
            'documents' => 'required|file|mimes:pdf,jpg,png|max:5120',
        ]);

        $company = auth()->user()->company;
        $path = $request->file('documents')->store('companies/verification', 'public');
        $company->update(['verification_documents' => $path]);

        return back()->with('success', 'Verification request submitted!');
    }
}
