<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // First, update any existing 'reviewing' values to 'under_review'
        DB::statement("UPDATE job_applications SET status = 'pending' WHERE status = 'reviewing'");

        // Then alter the ENUM column to include all correct values
        DB::statement("ALTER TABLE job_applications MODIFY COLUMN status ENUM('pending', 'under_review', 'shortlisted', 'interviewed', 'offered', 'accepted', 'rejected', 'withdrawn') DEFAULT 'pending'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert to original ENUM values
        DB::statement("UPDATE job_applications SET status = 'pending' WHERE status IN ('under_review', 'interviewed', 'offered')");
        DB::statement("ALTER TABLE job_applications MODIFY COLUMN status ENUM('pending', 'reviewing', 'shortlisted', 'rejected', 'accepted', 'withdrawn') DEFAULT 'pending'");
    }
};
