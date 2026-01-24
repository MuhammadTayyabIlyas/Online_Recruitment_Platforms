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
        Schema::create('user_certifications', function (Blueprint $table) {
            $table->id();

            // Foreign key to users table
            $table->foreignId('user_id')
                  ->constrained('users')
                  ->onDelete('cascade');

            // Certification details
            $table->string('name', 255);
            $table->string('issuing_organization', 255);

            // Date information
            $table->date('issue_date');
            $table->date('expiry_date')->nullable();

            // Credential information
            $table->string('credential_id', 255)->nullable();
            $table->string('credential_url', 500)->nullable();

            $table->timestamps();
            $table->softDeletes();

            // Add indexes
            $table->index(['user_id', 'issuing_organization']);
            $table->index('expiry_date');
            $table->index('issue_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_certifications');
    }
};
