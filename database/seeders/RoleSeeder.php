<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Define permissions
        $permissions = [
            // User management
            'view users',
            'create users',
            'edit users',
            'delete users',
            'manage users',

            // Job management
            'view jobs',
            'create jobs',
            'edit jobs',
            'delete jobs',
            'manage jobs',
            'apply jobs',

            // Study program management
            'view programs',
            'create programs',
            'edit programs',
            'delete programs',
            'manage programs',
            'apply programs',
            'review program applications',

            // Application management
            'view applications',
            'create applications',
            'edit applications',
            'delete applications',
            'manage applications',
            'review applications',

            // Company management
            'view companies',
            'create companies',
            'edit companies',
            'delete companies',
            'manage companies',

            // Resume management
            'view resumes',
            'create resumes',
            'edit resumes',
            'delete resumes',

            // Dashboard access
            'access admin dashboard',
            'access employer dashboard',
            'access job seeker dashboard',
            'access service user dashboard',

            // Police Certificate Services
            'apply police certificate',
            'view police certificates',

            // Reports
            'view reports',
            'generate reports',

            // Settings
            'manage settings',
            'manage roles',
            'manage permissions',
        ];

        // Create permissions
        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission, 'guard_name' => 'web']);
        }

        // Create roles and assign permissions

        // Admin role - full access
        $adminRole = Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);
        $adminRole->givePermissionTo(Permission::all());

        // Employer role
        $employerRole = Role::firstOrCreate(['name' => 'employer', 'guard_name' => 'web']);
        $employerRole->givePermissionTo([
            'view jobs',
            'create jobs',
            'edit jobs',
            'delete jobs',
            'view applications',
            'review applications',
            'view companies',
            'create companies',
            'edit companies',
            'view resumes',
            'access employer dashboard',
        ]);

        // Job Seeker role
        $jobSeekerRole = Role::firstOrCreate(['name' => 'job_seeker', 'guard_name' => 'web']);
        $jobSeekerRole->givePermissionTo([
            'view jobs',
            'apply jobs',
            'view applications',
            'create applications',
            'view resumes',
            'create resumes',
            'edit resumes',
            'delete resumes',
            'access job seeker dashboard',
        ]);

        // Educational Institution role
        $institutionRole = Role::firstOrCreate(['name' => 'educational_institution', 'guard_name' => 'web']);
        $institutionRole->givePermissionTo([
            'view programs',
            'create programs',
            'edit programs',
            'delete programs',
            'manage programs',
            'review program applications',
            'access employer dashboard',
        ]);

        // Student role
        $studentRole = Role::firstOrCreate(['name' => 'student', 'guard_name' => 'web']);
        $studentRole->givePermissionTo([
            'view programs',
            'apply programs',
            'access job seeker dashboard',
        ]);

        // Service User role (Police Certificates & Other Services)
        $serviceUserRole = Role::firstOrCreate(['name' => 'service_user', 'guard_name' => 'web']);
        $serviceUserRole->givePermissionTo([
            'apply police certificate',
            'view police certificates',
            'access service user dashboard',
        ]);

        $this->command->info('Roles and permissions seeded successfully!');
    }
}
