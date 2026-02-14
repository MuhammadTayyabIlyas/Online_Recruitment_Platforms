<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('police_certificate_applications', function (Blueprint $table) {
            $table->boolean('apostille_required')->default(false)->after('service_type');
        });

        Schema::table('greece_certificate_applications', function (Blueprint $table) {
            $table->boolean('apostille_required')->default(false)->after('service_type');
        });

        Schema::table('portugal_certificate_applications', function (Blueprint $table) {
            $table->boolean('apostille_required')->default(false)->after('service_type');
        });
    }

    public function down(): void
    {
        Schema::table('police_certificate_applications', function (Blueprint $table) {
            $table->dropColumn('apostille_required');
        });

        Schema::table('greece_certificate_applications', function (Blueprint $table) {
            $table->dropColumn('apostille_required');
        });

        Schema::table('portugal_certificate_applications', function (Blueprint $table) {
            $table->dropColumn('apostille_required');
        });
    }
};
