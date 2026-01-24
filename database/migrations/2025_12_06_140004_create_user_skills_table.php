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
        Schema::create('user_skills', function (Blueprint $table) {
            $table->id();

            // Foreign key to users table
            $table->foreignId('user_id')
                  ->constrained('users')
                  ->onDelete('cascade');

            // Skill information - normalized to lowercase for consistency
            $table->string('skill_name', 100);

            // Proficiency level
            $table->enum('proficiency_level', [
                'beginner',
                'intermediate',
                'advanced',
                'expert'
            ])->default('intermediate');

            // Years of experience
            $table->unsignedTinyInteger('years_of_experience')->default(0);

            $table->timestamps();
            $table->softDeletes();

            // Add unique constraint to prevent duplicate skills per user
            $table->unique(['user_id', 'skill_name']);

            // Add indexes
            $table->index('skill_name');
            $table->index('proficiency_level');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_skills');
    }
};
