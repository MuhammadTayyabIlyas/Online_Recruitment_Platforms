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
        Schema::create('programs', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique(); // For SEO friendly URLs
            $table->foreignId('university_id')->constrained()->onDelete('cascade');
            $table->foreignId('country_id')->constrained()->onDelete('cascade'); // Denormalized for easier filtering
            $table->foreignId('degree_id')->constrained()->onDelete('cascade');
            $table->foreignId('subject_id')->constrained()->onDelete('cascade');
            $table->string('language')->default('English');
            $table->decimal('tuition_fee', 10, 2)->nullable(); // Nullable for "Contact for price" or free
            $table->string('currency')->default('EUR');
            $table->string('duration')->nullable(); // e.g., "2 years", "18 months"
            $table->string('intake')->nullable(); // e.g., "September 2026", "Spring 2026"
            $table->string('study_mode')->default('On-campus'); // On-campus, Online, Hybrid
            $table->date('application_deadline')->nullable();
            $table->string('program_url')->nullable(); // External application link
            $table->boolean('is_featured')->default(false);
            $table->text('description')->nullable(); // Added description for detail page
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('programs');
    }
};
