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
        Schema::create('user_documents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->integer('document_number')->comment('Document sequence number 1-10');
            $table->string('file_name');
            $table->string('file_path');
            $table->string('original_name');
            $table->integer('file_size')->comment('File size in bytes');
            $table->string('mime_type')->default('application/pdf');
            $table->timestamps();

            // Ensure unique document number per user
            $table->unique(['user_id', 'document_number']);

            // Index for faster queries
            $table->index('user_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_documents');
    }
};
