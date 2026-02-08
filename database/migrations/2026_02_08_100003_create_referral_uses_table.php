<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('referral_uses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('referral_code_id')->constrained()->onDelete('cascade');
            $table->foreignId('referred_user_id')->constrained('users')->onDelete('cascade');
            $table->string('application_type');
            $table->unsignedBigInteger('application_id');
            $table->enum('status', ['pending', 'credited'])->default('pending');
            $table->timestamp('credited_at')->nullable();
            $table->timestamps();

            $table->unique(['referred_user_id', 'application_type', 'application_id'], 'referral_uses_unique');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('referral_uses');
    }
};
