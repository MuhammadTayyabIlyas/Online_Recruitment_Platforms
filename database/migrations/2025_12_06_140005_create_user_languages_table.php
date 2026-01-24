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
        Schema::create('user_languages', function (Blueprint $table) {
            $table->id();

            // Foreign key to users table
            $table->foreignId('user_id')
                  ->constrained('users')
                  ->onDelete('cascade');

            // Language information
            $table->string('language', 100);

            // Proficiency level
            $table->enum('proficiency', [
                'basic',
                'conversational',
                'fluent',
                'native'
            ])->default('conversational');

            $table->timestamps();
            $table->softDeletes();

            // Add unique constraint to prevent duplicate languages per user
            $table->unique(['user_id', 'language']);

            // Add indexes
            $table->index('language');
            $table->index('proficiency');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_languages');
    }
};
