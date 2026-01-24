<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\UserProfile;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get admin credentials from environment or use defaults
        $adminEmail = env('ADMIN_EMAIL', 'admin@placemenet.com');
        $adminPassword = env('ADMIN_PASSWORD', 'Admin@123456');
        $adminName = env('ADMIN_NAME', 'System Administrator');

        // Check if admin already exists
        $existingAdmin = User::where('email', $adminEmail)->first();

        if ($existingAdmin) {
            $this->command->warn("Admin user with email {$adminEmail} already exists.");

            // Ensure admin has the admin role
            if (!$existingAdmin->hasRole('admin')) {
                $existingAdmin->assignRole('admin');
                $this->command->info('Admin role assigned to existing user.');
            }

            return;
        }

        // Create admin user
        $admin = User::create([
            'name' => $adminName,
            'email' => $adminEmail,
            'password' => Hash::make($adminPassword),
            'user_type' => 'admin',
            'email_verified_at' => now(),
            'is_active' => true,
        ]);

        // Assign admin role
        $admin->assignRole('admin');

        // Create admin profile
        UserProfile::create([
            'user_id' => $admin->id,
            'phone' => env('ADMIN_PHONE', '+1234567890'),
            'address' => env('ADMIN_ADDRESS', 'System Administration'),
            'city' => env('ADMIN_CITY', 'System'),
            'country' => env('ADMIN_COUNTRY', 'System'),
            'bio' => 'System Administrator for PlaceMeNet Job Placement Platform',
            'profile_completed' => true,
        ]);

        // Log admin creation (without password)
        Log::info('Admin user created', [
            'email' => $adminEmail,
            'name' => $adminName,
            'created_at' => now()->toDateTimeString(),
        ]);

        $this->command->info("Admin user created successfully!");
        $this->command->info("Email: {$adminEmail}");
        $this->command->warn("Please change the default password after first login!");
    }
}
