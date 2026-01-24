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
        Schema::create('student_documents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('document_type'); // transcript, certificate, passport, recommendation, etc.
            $table->string('document_name'); // User-given name
            $table->string('file_path');
            $table->string('original_filename');
            $table->integer('file_size'); // in bytes
            $table->string('mime_type')->default('application/pdf');
            $table->boolean('is_verified')->default(false);
            $table->timestamps();

            $table->index(['user_id', 'document_type']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_documents');
    }
};
