<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\BlogCategory;

class BlogCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Study Abroad Guides',
                'description' => 'Comprehensive guides for studying in different countries',
                'sort_order' => 1,
                'is_active' => true,
            ],
            [
                'name' => 'Admissions & Applications',
                'description' => 'Tips and guidance for university admissions',
                'sort_order' => 2,
                'is_active' => true,
            ],
            [
                'name' => 'Scholarships',
                'description' => 'Information about scholarships and financial aid',
                'sort_order' => 3,
                'is_active' => true,
            ],
            [
                'name' => 'Immigration & Visas',
                'description' => 'Visa application processes and immigration guidance',
                'sort_order' => 4,
                'is_active' => true,
            ],
            [
                'name' => 'Career Advice',
                'description' => 'Professional development and career tips',
                'sort_order' => 5,
                'is_active' => true,
            ],
            [
                'name' => 'AI & Education',
                'description' => 'How AI is transforming education and careers',
                'sort_order' => 6,
                'is_active' => true,
            ],
            [
                'name' => 'Employer Insights',
                'description' => 'Industry trends and employer perspectives',
                'sort_order' => 7,
                'is_active' => true,
            ],
            [
                'name' => 'Success Stories',
                'description' => 'Inspiring stories from our community',
                'sort_order' => 8,
                'is_active' => true,
            ],
        ];

        foreach ($categories as $category) {
            BlogCategory::create($category);
        }
    }
}
