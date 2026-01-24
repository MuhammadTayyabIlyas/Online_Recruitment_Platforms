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
        Schema::create('user_resumes', function (Blueprint $table) {
            $table->id();

            // Foreign key to users table
            $table->foreignId('user_id')
                  ->constrained('users')
                  ->onDelete('cascade');

            // Resume details
            $table->string('title', 255);

            // File information - path is relative to storage disk
            $table->string('file_path', 500);
            $table->string('file_name', 255);
            $table->unsignedBigInteger('file_size');
            $table->string('mime_type', 100)->default('application/pdf');

            // Resume status
            $table->boolean('is_primary')->default(false);
            $table->unsignedInteger('download_count')->default(0);

            $table->timestamps();
            $table->softDeletes();

            // Add indexes
            $table->index(['user_id', 'is_primary']);
            $table->index('download_count');
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_resumes');
    }
};
