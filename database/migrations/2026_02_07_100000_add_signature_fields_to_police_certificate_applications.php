<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('police_certificate_applications', function (Blueprint $table) {
            $table->longText('signature_data')->nullable();
            $table->string('signature_place', 200)->nullable();
            $table->date('signature_date')->nullable();
            $table->string('signature_method', 20)->nullable();
            $table->boolean('authorization_letter_uploaded')->default(false);
        });
    }

    public function down(): void
    {
        Schema::table('police_certificate_applications', function (Blueprint $table) {
            $table->dropColumn([
                'signature_data',
                'signature_place',
                'signature_date',
                'signature_method',
                'authorization_letter_uploaded',
            ]);
        });
    }
};
