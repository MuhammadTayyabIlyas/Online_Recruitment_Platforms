<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WhatsAppService
{
    protected string $apiUrl;
    protected string $apiKey;
    protected array $instances;
    protected string $adminNumber;

    public function __construct()
    {
        $this->apiUrl = rtrim(config('services.evolution.api_url', 'http://localhost:8080'), '/');
        $this->apiKey = config('services.evolution.api_key', '');
        $this->instances = config('services.evolution.instances', []);
        $this->adminNumber = config('services.evolution.admin_number', '');
    }

    /**
     * Send a text message via Evolution API.
     */
    public function sendText(string $instance, string $number, string $message): bool
    {
        if (empty($this->apiKey) || empty($number)) {
            return false;
        }

        $number = $this->formatPhoneNumber($number);

        try {
            $response = Http::withHeaders([
                'apikey' => $this->apiKey,
                'Content-Type' => 'application/json',
            ])->post("{$this->apiUrl}/message/sendText/{$instance}", [
                'number' => $number,
                'text' => $message,
            ]);

            if ($response->successful()) {
                return true;
            }

            Log::warning('WhatsApp send failed', [
                'instance' => $instance,
                'status' => $response->status(),
                'body' => $response->body(),
            ]);

            return false;
        } catch (\Exception $e) {
            Log::error('WhatsApp send error', [
                'instance' => $instance,
                'error' => $e->getMessage(),
            ]);

            return false;
        }
    }

    /**
     * Format phone number to digits only.
     */
    public function formatPhoneNumber(string $phone): string
    {
        return preg_replace('/[^0-9]/', '', $phone);
    }

    /**
     * Get Evolution API instance name for a certificate service.
     */
    public function getInstanceForService(string $service): string
    {
        return $this->instances[$service] ?? $this->instances['uk-police'] ?? 'uk-5000';
    }

    /**
     * Send notification to admin when a certificate application is submitted.
     */
    public function sendCertificateSubmissionNotification($application, string $service): bool
    {
        $instance = $this->getInstanceForService($service);
        $serviceLabels = [
            'uk-police' => 'UK Police Certificate',
            'greece' => 'Greece Penal Record',
            'portugal' => 'Portugal Criminal Record',
        ];

        $serviceName = $serviceLabels[$service] ?? ucfirst($service);
        $name = $application->first_name . ' ' . $application->last_name;
        $ref = $application->application_reference;
        $serviceType = ucfirst($application->service_type ?? 'normal');
        $apostille = $application->apostille_required ? "\nApostille: Yes" : '';

        $message = "New {$serviceName} Application!\n\n"
            . "Ref: {$ref}\n"
            . "Client: {$name}\n"
            . "Service: {$serviceType}{$apostille}\n"
            . "Email: {$application->email}";

        return $this->sendText($instance, $this->adminNumber, $message);
    }

    /**
     * Send appointment booking notification to admin.
     */
    public function sendAppointmentBookedNotification($appointment): bool
    {
        $instance = $this->instances['uk-police'] ?? 'uk-5000';
        $date = $appointment->appointment_date->format('D, M d, Y');
        $time = \Carbon\Carbon::parse($appointment->start_time)->format('H:i');
        $format = ucfirst($appointment->meeting_format ?? 'online');
        $type = $appointment->consultationType->name ?? 'Consultation';

        $message = "New Appointment Booked!\n\n"
            . "Ref: {$appointment->booking_reference}\n"
            . "Client: {$appointment->booker_name}\n"
            . "Date: {$date} at {$time}\n"
            . "Format: {$format}\n"
            . "Type: {$type}";

        return $this->sendText($instance, $this->adminNumber, $message);
    }

    /**
     * Send appointment reminder to admin.
     */
    public function sendAppointmentReminderAdmin($appointment, string $timeLabel): bool
    {
        $instance = $this->instances['uk-police'] ?? 'uk-5000';
        $date = $appointment->appointment_date->format('D, M d, Y');
        $time = \Carbon\Carbon::parse($appointment->start_time)->format('H:i');
        $phone = $appointment->booker_phone ? " ({$appointment->booker_phone})" : '';

        $message = "Upcoming Appointment in {$timeLabel}\n\n"
            . "Ref: {$appointment->booking_reference}\n"
            . "Client: {$appointment->booker_name}{$phone}\n"
            . "Date: {$date} at {$time}";

        return $this->sendText($instance, $this->adminNumber, $message);
    }

    /**
     * Send appointment reminder to client.
     */
    public function sendAppointmentReminderClient($appointment, string $timeLabel): bool
    {
        if (empty($appointment->booker_phone)) {
            return false;
        }

        $instance = $this->instances['uk-police'] ?? 'uk-5000';
        $date = $appointment->appointment_date->format('D, M d, Y');
        $time = \Carbon\Carbon::parse($appointment->start_time)->format('H:i');
        $type = $appointment->consultationType->name ?? 'Consultation';

        $message = "Reminder: Your appointment is in {$timeLabel}\n\n"
            . "Ref: {$appointment->booking_reference}\n"
            . "Date: {$date} at {$time}\n"
            . "Type: {$type}";

        return $this->sendText($instance, $appointment->booker_phone, $message);
    }
}
