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
        Schema::create('user_experience', function (Blueprint $table) {
            $table->id();

            // Foreign key to users table
            $table->foreignId('user_id')
                  ->constrained('users')
                  ->onDelete('cascade');

            // Job details
            $table->string('company_name', 255);
            $table->string('job_title', 255);
            $table->string('location', 255)->nullable();

            // Employment dates
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->boolean('is_current')->default(false);

            // Employment type
            $table->enum('employment_type', [
                'full_time',
                'part_time',
                'contract',
                'freelance',
                'internship',
                'apprenticeship',
                'temporary'
            ])->default('full_time');

            // Job description
            $table->text('description')->nullable();

            $table->timestamps();
            $table->softDeletes();

            // Add indexes
            $table->index(['user_id', 'is_current']);
            $table->index('company_name');
            $table->index('employment_type');
            $table->index('start_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_experience');
    }
};
