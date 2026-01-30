<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('police_certificate_applications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
            
            // Step 1: Personal Information
            $table->string('first_name');
            $table->string('middle_name')->nullable();
            $table->string('last_name');
            $table->string('father_full_name');
            $table->enum('gender', ['male', 'female', 'other']);
            $table->date('date_of_birth');
            $table->string('place_of_birth_city');
            $table->string('place_of_birth_country');
            $table->string('nationality')->default('Pakistani');
            $table->enum('marital_status', ['single', 'married', 'divorced', 'widowed']);
            
            // Step 2: Identification
            $table->string('passport_number');
            $table->date('passport_issue_date');
            $table->date('passport_expiry_date');
            $table->string('passport_place_of_issue');
            $table->string('cnic_nicop_number');
            $table->string('uk_home_office_ref')->nullable();
            $table->string('uk_brp_number')->nullable();
            
            // Step 3: UK Residence History (JSON array)
            $table->json('uk_residence_history');
            $table->string('uk_national_insurance_number')->nullable();
            
            // Step 4: UK Address History (JSON array)
            $table->json('uk_address_history');
            
            // Step 5: Spain Address
            $table->string('spain_address_line1');
            $table->string('spain_address_line2')->nullable();
            $table->string('spain_city');
            $table->string('spain_province');
            $table->string('spain_postal_code');
            
            // Step 6: Contact
            $table->string('email');
            $table->string('phone_spain');
            $table->string('whatsapp_number')->nullable();
            
            // Step 7: Service Selection & Payment
            $table->enum('service_type', ['normal', 'urgent']);
            $table->enum('payment_currency', ['gbp', 'eur']);
            $table->decimal('payment_amount', 10, 2);
            $table->enum('payment_status', ['pending', 'paid', 'verified', 'refunded'])->default('pending');
            $table->timestamp('payment_verified_at')->nullable();
            $table->foreignId('payment_verified_by')->nullable()->constrained('users');
            
            // Application Status
            $table->enum('status', ['draft', 'submitted', 'payment_pending', 'payment_verified', 'processing', 'completed', 'rejected'])->default('draft');
            $table->string('application_reference')->unique();
            
            // Timestamps
            $table->timestamp('submitted_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('police_certificate_applications');
    }
};