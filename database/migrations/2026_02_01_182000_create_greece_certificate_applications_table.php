<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('greece_certificate_applications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');

            // Step 1: Personal Information
            $table->string('first_name')->nullable();
            $table->string('middle_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('father_name')->nullable();
            $table->string('mother_name')->nullable();
            $table->enum('gender', ['male', 'female', 'other'])->nullable();
            $table->date('date_of_birth')->nullable();
            $table->string('place_of_birth_city')->nullable();
            $table->string('place_of_birth_country')->nullable();
            $table->string('nationality')->default('Pakistani');

            // Step 2: Identification Documents
            $table->string('passport_number')->nullable();
            $table->date('passport_issue_date')->nullable();
            $table->date('passport_expiry_date')->nullable();
            $table->string('passport_place_of_issue')->nullable();
            $table->string('greece_afm')->nullable(); // Greek Tax ID (AFM)
            $table->string('greece_amka')->nullable(); // Greek Social Security Number
            $table->string('greece_residence_permit')->nullable();
            $table->date('greece_residence_permit_expiry')->nullable();

            // Step 3: Greece Residence History (JSON array)
            $table->json('greece_residence_history')->nullable();

            // Step 4: Current Address
            $table->string('current_address_line1')->nullable();
            $table->string('current_address_line2')->nullable();
            $table->string('current_city')->nullable();
            $table->string('current_postal_code')->nullable();
            $table->string('current_country')->nullable();

            // Step 5: Contact Information
            $table->string('email')->nullable();
            $table->string('phone_number')->nullable();
            $table->string('whatsapp_number')->nullable();

            // Step 6: Authorization Letter Upload
            $table->boolean('authorization_letter_uploaded')->default(false);

            // Step 7: Certificate Purpose & Service Type
            $table->enum('certificate_purpose', [
                'employment',
                'immigration',
                'visa',
                'residency',
                'education',
                'adoption',
                'other'
            ])->nullable();
            $table->string('purpose_details')->nullable();
            $table->enum('service_type', ['normal', 'urgent'])->nullable();
            $table->enum('payment_currency', ['eur'])->default('eur');
            $table->decimal('payment_amount', 10, 2)->nullable();
            $table->enum('payment_status', ['pending', 'paid', 'verified', 'refunded'])->default('pending');
            $table->timestamp('payment_verified_at')->nullable();
            $table->foreignId('payment_verified_by')->nullable()->constrained('users');

            // Application Status
            $table->enum('status', ['draft', 'submitted', 'payment_pending', 'payment_verified', 'processing', 'completed', 'rejected'])->default('draft');
            $table->string('application_reference')->unique();
            $table->text('admin_notes')->nullable();

            // Disclaimer & Timestamps
            $table->timestamp('disclaimer_accepted_at')->nullable();
            $table->timestamp('submitted_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('greece_certificate_applications');
    }
};
