<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            $table->string('booking_reference')->unique();
            $table->foreignId('consultation_type_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');

            // Booker info
            $table->string('booker_name');
            $table->string('booker_email');
            $table->string('booker_phone')->nullable();

            // Schedule
            $table->date('appointment_date');
            $table->time('start_time');
            $table->time('end_time');
            $table->unsignedInteger('duration_minutes');

            // Format
            $table->enum('meeting_format', ['in_person', 'online'])->default('online');
            $table->string('office_key')->nullable();
            $table->string('meeting_link')->nullable();

            // Payment
            $table->decimal('price', 8, 2)->default(0);
            $table->string('currency', 3)->default('EUR');
            $table->boolean('is_free')->default(true);
            $table->enum('payment_status', ['not_required', 'pending', 'completed', 'refunded'])->default('not_required');
            $table->string('stripe_payment_intent_id')->nullable();
            $table->timestamp('paid_at')->nullable();

            // Status
            $table->enum('status', ['pending', 'confirmed', 'cancelled', 'completed', 'no_show', 'rescheduled'])->default('pending');

            // Meta
            $table->text('notes')->nullable();
            $table->text('admin_notes')->nullable();
            $table->string('cancellation_reason')->nullable();
            $table->timestamp('cancelled_at')->nullable();
            $table->string('cancelled_by')->nullable(); // 'user', 'admin'
            $table->timestamp('reminder_24h_sent_at')->nullable();
            $table->timestamp('reminder_1h_sent_at')->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->index(['appointment_date', 'start_time', 'end_time']);
            $table->index('status');
            $table->index('booker_email');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
};
