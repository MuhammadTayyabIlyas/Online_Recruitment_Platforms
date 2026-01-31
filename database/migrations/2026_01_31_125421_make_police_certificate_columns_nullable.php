<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Make columns nullable to support multi-step form submission.
     */
    public function up(): void
    {
        Schema::table('police_certificate_applications', function (Blueprint $table) {
            // Step 1 fields - make nullable for draft state
            $table->string('first_name')->nullable()->change();
            $table->string('last_name')->nullable()->change();
            $table->string('father_full_name')->nullable()->change();
            $table->date('date_of_birth')->nullable()->change();
            $table->string('place_of_birth_city')->nullable()->change();
            $table->string('place_of_birth_country')->nullable()->change();

            // Step 2 fields
            $table->string('passport_number')->nullable()->change();
            $table->date('passport_issue_date')->nullable()->change();
            $table->date('passport_expiry_date')->nullable()->change();
            $table->string('passport_place_of_issue')->nullable()->change();
            $table->string('cnic_nicop_number')->nullable()->change();

            // Step 3 & 4 fields
            $table->json('uk_residence_history')->nullable()->change();
            $table->json('uk_address_history')->nullable()->change();

            // Step 5 fields
            $table->string('spain_address_line1')->nullable()->change();
            $table->string('spain_city')->nullable()->change();
            $table->string('spain_province')->nullable()->change();
            $table->string('spain_postal_code')->nullable()->change();

            // Step 6 fields
            $table->string('email')->nullable()->change();
            $table->string('phone_spain')->nullable()->change();

            // Step 7 fields
            $table->decimal('payment_amount', 10, 2)->nullable()->change();
        });

        // Handle enum columns with raw SQL (Laravel doesn't support enum->nullable change well)
        DB::statement("ALTER TABLE police_certificate_applications MODIFY gender ENUM('male', 'female', 'other') NULL");
        DB::statement("ALTER TABLE police_certificate_applications MODIFY marital_status ENUM('single', 'married', 'divorced', 'widowed') NULL");
        DB::statement("ALTER TABLE police_certificate_applications MODIFY service_type ENUM('normal', 'urgent') NULL");
        DB::statement("ALTER TABLE police_certificate_applications MODIFY payment_currency ENUM('gbp', 'eur') NULL");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Note: Reversing this migration would require ensuring all data is filled first
        // This is left empty intentionally as it's a one-way change for form support
    }
};
