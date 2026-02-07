<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Add UX improvement fields to UK Police Certificate Applications
        Schema::table('police_certificate_applications', function (Blueprint $table) {
            $table->boolean('address_dates_approximate')->default(false)->after('uk_address_history');
            $table->text('address_dates_notes')->nullable()->after('address_dates_approximate');
            $table->integer('last_completed_step')->default(0)->after('status');
            $table->timestamp('last_saved_at')->nullable()->after('last_completed_step');

            // "I don't have this" checkboxes for optional fields
            $table->boolean('no_uk_home_office_ref')->default(false)->after('uk_home_office_ref');
            $table->boolean('no_uk_brp_number')->default(false)->after('uk_brp_number');
            $table->boolean('no_uk_national_insurance_number')->default(false)->after('uk_national_insurance_number');
        });

        // Add UX improvement fields to Portugal Certificate Applications
        Schema::table('portugal_certificate_applications', function (Blueprint $table) {
            $table->boolean('address_dates_approximate')->default(false)->after('portugal_residence_history');
            $table->text('address_dates_notes')->nullable()->after('address_dates_approximate');
            $table->integer('last_completed_step')->default(0)->after('status');
            $table->timestamp('last_saved_at')->nullable()->after('last_completed_step');

            // "I don't have this" checkboxes for optional fields
            $table->boolean('no_portugal_nif')->default(false)->after('portugal_nif');
            $table->boolean('no_portugal_residence_permit')->default(false)->after('portugal_residence_permit');
            $table->boolean('no_portugal_social_security_number')->default(false)->after('portugal_social_security_number');
        });

        // Add UX improvement fields to Greece Certificate Applications
        Schema::table('greece_certificate_applications', function (Blueprint $table) {
            $table->boolean('address_dates_approximate')->default(false)->after('greece_residence_history');
            $table->text('address_dates_notes')->nullable()->after('address_dates_approximate');
            $table->integer('last_completed_step')->default(0)->after('status');
            $table->timestamp('last_saved_at')->nullable()->after('last_completed_step');

            // "I don't have this" checkboxes for optional fields
            $table->boolean('no_greece_afm')->default(false)->after('greece_afm');
            $table->boolean('no_greece_amka')->default(false)->after('greece_amka');
        });
    }

    public function down(): void
    {
        Schema::table('police_certificate_applications', function (Blueprint $table) {
            $table->dropColumn([
                'address_dates_approximate',
                'address_dates_notes',
                'last_completed_step',
                'last_saved_at',
                'no_uk_home_office_ref',
                'no_uk_brp_number',
                'no_uk_national_insurance_number',
            ]);
        });

        Schema::table('portugal_certificate_applications', function (Blueprint $table) {
            $table->dropColumn([
                'address_dates_approximate',
                'address_dates_notes',
                'last_completed_step',
                'last_saved_at',
                'no_portugal_nif',
                'no_portugal_residence_permit',
                'no_portugal_social_security_number',
            ]);
        });

        Schema::table('greece_certificate_applications', function (Blueprint $table) {
            $table->dropColumn([
                'address_dates_approximate',
                'address_dates_notes',
                'last_completed_step',
                'last_saved_at',
                'no_greece_afm',
                'no_greece_amka',
            ]);
        });
    }
};
