<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('greece_certificate_applications', function (Blueprint $table) {
            $table->text('signature_data')->nullable()->after('authorization_letter_uploaded');
            $table->string('signature_place', 200)->nullable()->after('signature_data');
            $table->date('signature_date')->nullable()->after('signature_place');
            $table->string('signature_method', 20)->nullable()->after('signature_date');
        });
    }

    public function down(): void
    {
        Schema::table('greece_certificate_applications', function (Blueprint $table) {
            $table->dropColumn(['signature_data', 'signature_place', 'signature_date', 'signature_method']);
        });
    }
};
