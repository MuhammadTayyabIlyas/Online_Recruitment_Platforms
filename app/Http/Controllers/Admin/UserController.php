<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Package;
use App\Models\User;
use App\Models\UserDocument;
use App\Models\UserResume;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::query();

        // Filter by search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // Filter by user type
        if ($request->filled('type') && $request->type !== 'all') {
            $query->where('user_type', $request->type);
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('is_active', $request->status === 'active');
        }

        $users = $query
            ->with(['subscriptions.package'])
            ->latest()
            ->paginate(15)
            ->withQueryString();

        $packages = Package::active()->ordered()->get();

        return view('admin.users.index', compact('users', 'packages'));
    }

    public function create()
    {
        $roles = Role::all();
        return view('admin.users.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'user_type' => 'required|in:admin,employer,job_seeker',
            'is_active' => 'boolean',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'user_type' => $request->user_type,
            'is_active' => $request->boolean('is_active', true),
            'email_verified_at' => now(), // Auto-verify admin-created accounts
        ]);

        // Assign role based on user_type
        $user->assignRole($request->user_type);

        // Create profile for job seekers
        if ($request->user_type === 'job_seeker') {
            $user->profile()->create([
                'bio' => '',
            ]);
        }

        // Create company for employers
        if ($request->user_type === 'employer') {
            $user->company()->create([
                'company_name' => $request->company_name ?? $request->name . "'s Company",
                'is_cv_access_approved' => false,
            ]);
        }

        return redirect()->route('admin.users.index')->with('success', 'User created successfully. Login credentials have been set.');
    }

    public function show(User $user)
    {
        $user->load([
            'profile',
            'company',
            'jobApplications.job',
            'jobs',
            'subscriptions.package',
            'education',
            'experience',
            'skills',
            'languages',
            'certifications',
            'resumes',
            'documents',
        ]);
        return view('admin.users.show', compact('user'));
    }

    public function edit(User $user)
    {
        $roles = Role::all();
        return view('admin.users.edit', compact('user', 'roles'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'user_type' => 'required|in:admin,employer,job_seeker',
            'is_active' => 'boolean',
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'user_type' => $request->user_type,
            'is_active' => $request->boolean('is_active'),
        ]);

        // Sync role based on user_type
        $user->syncRoles([$request->user_type]);

        return redirect()->route('admin.users.index')->with('success', 'User updated successfully.');
    }

    public function toggleStatus(User $user)
    {
        // Prevent admin from deactivating themselves
        if ($user->id === auth()->id()) {
            return back()->with('error', 'You cannot deactivate your own account.');
        }

        $user->update(['is_active' => !$user->is_active]);

        $status = $user->is_active ? 'activated' : 'deactivated';
        return back()->with('success', "User {$status} successfully.");
    }

    public function destroy(User $user)
    {
        // Prevent admin from deleting themselves
        if ($user->id === auth()->id()) {
            return back()->with('error', 'You cannot delete your own account.');
        }

        $user->delete();

        return redirect()->route('admin.users.index')->with('success', 'User deleted successfully.');
    }

    public function toggleCvAccess(User $user)
    {
        // Only employers with companies can have CV access
        if ($user->user_type !== 'employer' || !$user->company) {
            return back()->with('error', 'Only employers with companies can have CV access.');
        }

        $user->company->update([
            'is_cv_access_approved' => !$user->company->is_cv_access_approved
        ]);

        $status = $user->company->is_cv_access_approved ? 'granted' : 'revoked';
        return back()->with('success', "CV access {$status} successfully.");
    }

    public function assignPackage(Request $request, User $user)
    {
        // Only employers with companies can have packages
        if ($user->user_type !== 'employer' || !$user->company) {
            return back()->with('error', 'Only employers with companies can be assigned packages.');
        }

        $request->validate([
            'package_id' => 'required|exists:packages,id',
        ]);

        $package = Package::find($request->package_id);

        // Create new subscription for the user with required limits populated
        $subscription = $user->subscriptions()->create([
            'package_id' => $package->id,
            'amount_paid' => $package->price,
            'jobs_remaining' => $package->job_posts_limit,
            'featured_jobs_remaining' => $package->featured_jobs_limit,
            'cv_access_remaining' => $package->cv_access_limit,
            'status' => 'active',
            'starts_at' => now(),
            'expires_at' => now()->addDays($package->duration_days),
        ]);

        // Deactivate any existing active subscriptions
        $user->subscriptions()
            ->where('id', '!=', $subscription->id)
            ->where('status', 'active')
            ->update(['status' => 'expired']);

        return back()->with('success', "Package '{$package->name}' assigned successfully.");
    }

    public function downloadResume(User $user, UserResume $resume)
    {
        if ($resume->user_id !== $user->id) {
            abort(403);
        }

        $path = $resume->file_path;

        if (Storage::disk('private')->exists($path)) {
            return Storage::disk('private')->download($path, $resume->file_name);
        }

        if (Storage::disk('public')->exists($path)) {
            return Storage::disk('public')->download($path, $resume->file_name);
        }

        abort(404, 'Resume file not found.');
    }

    public function downloadDocument(User $user, UserDocument $document)
    {
        if ($document->user_id !== $user->id) {
            abort(403);
        }

        $path = $document->file_path;

        if (Storage::disk('private')->exists($path)) {
            return Storage::disk('private')->download($path, $document->file_name ?? $document->original_name);
        }

        if (Storage::disk('public')->exists($path)) {
            return Storage::disk('public')->download($path, $document->file_name ?? $document->original_name);
        }

        abort(404, 'Document file not found.');
    }
}
