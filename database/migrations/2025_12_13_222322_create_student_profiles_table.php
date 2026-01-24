<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('student_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->unique()->constrained()->onDelete('cascade');

            // Personal Information
            $table->date('date_of_birth')->nullable();
            $table->string('gender')->nullable();
            $table->string('nationality')->nullable();
            $table->string('country_of_residence')->nullable();
            $table->string('phone')->nullable();
            $table->text('address')->nullable();

            // Academic Background
            $table->string('current_education_level')->nullable(); // High School, Bachelor, Master, etc.
            $table->string('field_of_study')->nullable();
            $table->string('institution_name')->nullable();
            $table->decimal('gpa', 3, 2)->nullable();
            $table->string('gpa_scale')->default('4.0'); // 4.0, 5.0, 100, etc.
            $table->year('expected_graduation')->nullable();

            // Language Proficiency
            $table->json('languages')->nullable(); // [{language: 'English', proficiency: 'Native'}, ...]
            $table->string('english_test_type')->nullable(); // TOEFL, IELTS, etc.
            $table->string('english_test_score')->nullable();

            // Study Preferences
            $table->json('preferred_countries')->nullable();
            $table->json('preferred_fields')->nullable();
            $table->json('preferred_degree_levels')->nullable();
            $table->string('preferred_start_date')->nullable();
            $table->decimal('budget_min', 10, 2)->nullable();
            $table->decimal('budget_max', 10, 2)->nullable();
            $table->string('budget_currency')->default('EUR');

            // Additional Info
            $table->text('bio')->nullable();
            $table->text('achievements')->nullable();
            $table->text('extracurricular')->nullable();
            $table->text('work_experience')->nullable();

            // Profile Status
            $table->integer('profile_completion')->default(0); // 0-100%
            $table->boolean('is_complete')->default(false);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_profiles');
    }
};
