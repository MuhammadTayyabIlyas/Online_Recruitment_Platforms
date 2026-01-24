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
        Schema::create('user_education', function (Blueprint $table) {
            $table->id();

            // Foreign key to users table
            $table->foreignId('user_id')
                  ->constrained('users')
                  ->onDelete('cascade');

            // Education details
            $table->string('institution', 255);
            $table->string('degree', 255);
            $table->string('field_of_study', 255);

            // Date information
            $table->year('start_date');
            $table->year('end_date')->nullable();
            $table->boolean('is_current')->default(false);

            // Additional information
            $table->string('grade', 50)->nullable();
            $table->text('description')->nullable();

            $table->timestamps();
            $table->softDeletes();

            // Add indexes
            $table->index(['user_id', 'is_current']);
            $table->index('institution');
            $table->index('start_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_education');
    }
};
