<?php

namespace Database\Seeders;

use App\Models\Package;
use Illuminate\Database\Seeder;

class PackageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $packages = [
            [
                'name' => 'Starter',
                'slug' => 'starter',
                'description' => 'Perfect for small businesses just getting started with hiring.',
                'price' => 49.00,
                'duration_days' => 30,
                'job_posts_limit' => 3,
                'featured_jobs_limit' => 0,
                'cv_access_limit' => 10,
                'has_priority_support' => false,
                'is_active' => true,
                'is_featured' => false,
                'features' => [
                    '3 Job Postings',
                    '30-day listing duration',
                    '10 CV Database views',
                    'Basic applicant tracking',
                    'Email notifications',
                ],
                'sort_order' => 1,
            ],
            [
                'name' => 'Professional',
                'slug' => 'professional',
                'description' => 'Ideal for growing companies with regular hiring needs.',
                'price' => 99.00,
                'duration_days' => 30,
                'job_posts_limit' => 10,
                'featured_jobs_limit' => 2,
                'cv_access_limit' => 50,
                'has_priority_support' => true,
                'is_active' => true,
                'is_featured' => true,
                'features' => [
                    '10 Job Postings',
                    '2 Featured Job Slots',
                    '30-day listing duration',
                    '50 CV Database views',
                    'Advanced applicant tracking',
                    'Email & SMS notifications',
                    'Priority support',
                ],
                'sort_order' => 2,
            ],
            [
                'name' => 'Enterprise',
                'slug' => 'enterprise',
                'description' => 'For large organizations with high-volume recruitment.',
                'price' => 249.00,
                'duration_days' => 30,
                'job_posts_limit' => 50,
                'featured_jobs_limit' => 10,
                'cv_access_limit' => 200,
                'has_priority_support' => true,
                'is_active' => true,
                'is_featured' => false,
                'features' => [
                    '50 Job Postings',
                    '10 Featured Job Slots',
                    '30-day listing duration',
                    '200 CV Database views',
                    'Advanced applicant tracking',
                    'Custom branding',
                    'API access',
                    'Dedicated account manager',
                    '24/7 Priority support',
                ],
                'sort_order' => 3,
            ],
            [
                'name' => 'Pay Per Post',
                'slug' => 'pay-per-post',
                'description' => 'Flexible option for occasional hiring needs.',
                'price' => 29.00,
                'duration_days' => 30,
                'job_posts_limit' => 1,
                'featured_jobs_limit' => 0,
                'cv_access_limit' => 5,
                'has_priority_support' => false,
                'is_active' => true,
                'is_featured' => false,
                'features' => [
                    '1 Job Posting',
                    '30-day listing duration',
                    '5 CV Database views',
                    'Basic applicant tracking',
                    'Email notifications',
                ],
                'sort_order' => 4,
            ],
        ];

        foreach ($packages as $package) {
            Package::updateOrCreate(
                ['slug' => $package['slug']],
                $package
            );
        }
    }
}
