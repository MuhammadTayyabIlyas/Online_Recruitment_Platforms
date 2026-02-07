<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('authorized_partners', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('reference_number', 30)->unique();
            $table->string('business_name', 255)->nullable();
            $table->string('tax_id', 50)->nullable();
            $table->string('address_line1', 255)->nullable();
            $table->string('address_line2', 255)->nullable();
            $table->string('city', 100)->nullable();
            $table->string('postal_code', 20)->nullable();
            $table->string('country', 100)->nullable();
            $table->string('phone', 30)->nullable();
            $table->string('email', 255)->nullable();
            $table->json('authorized_countries')->nullable();
            $table->enum('status', ['pending_profile', 'pending_review', 'active', 'suspended', 'revoked'])->default('pending_profile');
            $table->date('approved_at')->nullable();
            $table->date('expires_at')->nullable();
            $table->text('admin_notes')->nullable();
            $table->string('certificate_path')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('authorized_partners');
    }
};
