<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Industry;
use App\Models\JobType;
use App\Models\EmploymentType;
use App\Models\Skill;
use App\Models\Language;

class TaxonomySeeder extends Seeder
{
    public function run(): void
    {
        $this->seedCategories();
        $this->seedIndustries();
        $this->seedJobTypes();
        $this->seedEmploymentTypes();
        $this->seedSkills();
        $this->seedLanguages();

        $this->command->info('Taxonomies seeded successfully!');
    }

    protected function seedCategories(): void
    {
        $categories = [
            ['name' => 'Technology', 'icon' => 'computer', 'sort_order' => 1],
            ['name' => 'Healthcare', 'icon' => 'medical', 'sort_order' => 2],
            ['name' => 'Finance', 'icon' => 'currency-dollar', 'sort_order' => 3],
            ['name' => 'Marketing', 'icon' => 'megaphone', 'sort_order' => 4],
            ['name' => 'Sales', 'icon' => 'shopping-cart', 'sort_order' => 5],
            ['name' => 'Design', 'icon' => 'paint-brush', 'sort_order' => 6],
            ['name' => 'Engineering', 'icon' => 'cog', 'sort_order' => 7],
            ['name' => 'Human Resources', 'icon' => 'users', 'sort_order' => 8],
            ['name' => 'Legal', 'icon' => 'scale', 'sort_order' => 9],
            ['name' => 'Education', 'icon' => 'academic-cap', 'sort_order' => 10],
            ['name' => 'Customer Service', 'icon' => 'support', 'sort_order' => 11],
            ['name' => 'Operations', 'icon' => 'clipboard-list', 'sort_order' => 12],
            ['name' => 'Administration', 'icon' => 'office-building', 'sort_order' => 13],
            ['name' => 'Accounting', 'icon' => 'calculator', 'sort_order' => 14],
            ['name' => 'Writing', 'icon' => 'pencil', 'sort_order' => 15],
        ];

        foreach ($categories as $category) {
            Category::firstOrCreate(['name' => $category['name']], $category);
        }
    }

    protected function seedIndustries(): void
    {
        $industries = [
            ['name' => 'Information Technology', 'icon' => 'chip', 'sort_order' => 1],
            ['name' => 'Healthcare & Medical', 'icon' => 'heart', 'sort_order' => 2],
            ['name' => 'Financial Services', 'icon' => 'banknotes', 'sort_order' => 3],
            ['name' => 'E-commerce & Retail', 'icon' => 'shopping-bag', 'sort_order' => 4],
            ['name' => 'Manufacturing', 'icon' => 'building-office', 'sort_order' => 5],
            ['name' => 'Education & Training', 'icon' => 'book-open', 'sort_order' => 6],
            ['name' => 'Real Estate', 'icon' => 'home', 'sort_order' => 7],
            ['name' => 'Hospitality & Tourism', 'icon' => 'globe', 'sort_order' => 8],
            ['name' => 'Media & Entertainment', 'icon' => 'film', 'sort_order' => 9],
            ['name' => 'Telecommunications', 'icon' => 'phone', 'sort_order' => 10],
            ['name' => 'Energy & Utilities', 'icon' => 'bolt', 'sort_order' => 11],
            ['name' => 'Transportation & Logistics', 'icon' => 'truck', 'sort_order' => 12],
            ['name' => 'Agriculture', 'icon' => 'sun', 'sort_order' => 13],
            ['name' => 'Construction', 'icon' => 'wrench', 'sort_order' => 14],
            ['name' => 'Non-Profit & NGO', 'icon' => 'hand', 'sort_order' => 15],
        ];

        foreach ($industries as $industry) {
            Industry::firstOrCreate(['name' => $industry['name']], $industry);
        }
    }

    protected function seedJobTypes(): void
    {
        $jobTypes = [
            ['name' => 'On-site', 'description' => 'Work from the office location', 'sort_order' => 1],
            ['name' => 'Remote', 'description' => 'Work from anywhere', 'sort_order' => 2],
            ['name' => 'Hybrid', 'description' => 'Mix of on-site and remote work', 'sort_order' => 3],
        ];

        foreach ($jobTypes as $jobType) {
            JobType::firstOrCreate(['name' => $jobType['name']], $jobType);
        }
    }

    protected function seedEmploymentTypes(): void
    {
        $employmentTypes = [
            ['name' => 'Full-time', 'description' => 'Standard 40 hours per week', 'sort_order' => 1],
            ['name' => 'Part-time', 'description' => 'Less than 40 hours per week', 'sort_order' => 2],
            ['name' => 'Contract', 'description' => 'Fixed-term contract position', 'sort_order' => 3],
            ['name' => 'Freelance', 'description' => 'Project-based work', 'sort_order' => 4],
            ['name' => 'Internship', 'description' => 'Training or learning position', 'sort_order' => 5],
            ['name' => 'Temporary', 'description' => 'Short-term position', 'sort_order' => 6],
        ];

        foreach ($employmentTypes as $employmentType) {
            EmploymentType::firstOrCreate(['name' => $employmentType['name']], $employmentType);
        }
    }

    protected function seedSkills(): void
    {
        $skills = [
            // Technology
            'JavaScript', 'Python', 'PHP', 'Java', 'React', 'Vue.js', 'Angular', 'Node.js',
            'Laravel', 'Django', 'Ruby on Rails', 'SQL', 'MongoDB', 'AWS', 'Docker', 'Git',
            'TypeScript', 'GraphQL', 'REST API', 'CI/CD',
            // Design
            'UI/UX Design', 'Figma', 'Adobe Photoshop', 'Adobe Illustrator', 'Sketch',
            // Marketing
            'SEO', 'Google Analytics', 'Social Media Marketing', 'Content Marketing', 'Email Marketing',
            // Business
            'Project Management', 'Agile', 'Scrum', 'Data Analysis', 'Excel',
            'Communication', 'Leadership', 'Problem Solving', 'Team Management',
        ];

        foreach ($skills as $index => $skillName) {
            Skill::firstOrCreate(['name' => $skillName], [
                'name' => $skillName,
                'sort_order' => $index + 1,
            ]);
        }
    }

    protected function seedLanguages(): void
    {
        $languages = [
            ['name' => 'English', 'code' => 'en', 'native_name' => 'English', 'sort_order' => 1],
            ['name' => 'Spanish', 'code' => 'es', 'native_name' => 'Español', 'sort_order' => 2],
            ['name' => 'French', 'code' => 'fr', 'native_name' => 'Français', 'sort_order' => 3],
            ['name' => 'German', 'code' => 'de', 'native_name' => 'Deutsch', 'sort_order' => 4],
            ['name' => 'Chinese', 'code' => 'zh', 'native_name' => '中文', 'sort_order' => 5],
            ['name' => 'Japanese', 'code' => 'ja', 'native_name' => '日本語', 'sort_order' => 6],
            ['name' => 'Korean', 'code' => 'ko', 'native_name' => '한국어', 'sort_order' => 7],
            ['name' => 'Arabic', 'code' => 'ar', 'native_name' => 'العربية', 'sort_order' => 8],
            ['name' => 'Portuguese', 'code' => 'pt', 'native_name' => 'Português', 'sort_order' => 9],
            ['name' => 'Russian', 'code' => 'ru', 'native_name' => 'Русский', 'sort_order' => 10],
            ['name' => 'Hindi', 'code' => 'hi', 'native_name' => 'हिन्दी', 'sort_order' => 11],
            ['name' => 'Italian', 'code' => 'it', 'native_name' => 'Italiano', 'sort_order' => 12],
            ['name' => 'Dutch', 'code' => 'nl', 'native_name' => 'Nederlands', 'sort_order' => 13],
            ['name' => 'Turkish', 'code' => 'tr', 'native_name' => 'Türkçe', 'sort_order' => 14],
            ['name' => 'Urdu', 'code' => 'ur', 'native_name' => 'اردو', 'sort_order' => 15],
        ];

        foreach ($languages as $language) {
            Language::firstOrCreate(['code' => $language['code']], $language);
        }
    }
}
