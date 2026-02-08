<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('greece_certificate_applications', function (Blueprint $table) {
            $table->string('referral_code_used', 10)->nullable()->after('admin_notes');
        });

        Schema::table('portugal_certificate_applications', function (Blueprint $table) {
            $table->string('referral_code_used', 10)->nullable()->after('admin_notes');
        });

        Schema::table('police_certificate_applications', function (Blueprint $table) {
            $table->string('referral_code_used', 10)->nullable()->after('admin_notes');
        });
    }

    public function down(): void
    {
        Schema::table('greece_certificate_applications', function (Blueprint $table) {
            $table->dropColumn('referral_code_used');
        });

        Schema::table('portugal_certificate_applications', function (Blueprint $table) {
            $table->dropColumn('referral_code_used');
        });

        Schema::table('police_certificate_applications', function (Blueprint $table) {
            $table->dropColumn('referral_code_used');
        });
    }
};
