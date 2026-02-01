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
        Schema::create('greece_certificate_documents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('application_id')->constrained('greece_certificate_applications')->onDelete('cascade');
            $table->string('document_type'); // passport, residence_permit, authorization_letter, receipt
            $table->string('file_path');
            $table->string('original_filename');
            $table->string('mime_type')->nullable();
            $table->unsignedBigInteger('file_size')->nullable();
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('greece_certificate_documents');
    }
};
