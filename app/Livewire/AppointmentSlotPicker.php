<?php

namespace App\Livewire;

use App\Models\ConsultationType;
use App\Services\AppointmentService;
use Carbon\Carbon;
use Livewire\Component;

class AppointmentSlotPicker extends Component
{
    public int $consultationTypeId;
    public int $currentYear;
    public int $currentMonth;
    public ?string $selectedDate = null;
    public ?string $selectedSlotStart = null;
    public ?string $selectedSlotEnd = null;
    public array $availableDates = [];
    public array $availableSlots = [];

    public function mount(int $consultationTypeId)
    {
        $this->consultationTypeId = $consultationTypeId;
        $tz = config('appointments.timezone', 'Europe/Athens');
        $now = Carbon::now($tz);
        $this->currentYear = $now->year;
        $this->currentMonth = $now->month;
        $this->loadMonth();
    }

    public function loadMonth(): void
    {
        $type = ConsultationType::findOrFail($this->consultationTypeId);
        $service = app(AppointmentService::class);
        $this->availableDates = $service->getAvailableDatesForMonth($type, $this->currentYear, $this->currentMonth);
        $this->selectedDate = null;
        $this->selectedSlotStart = null;
        $this->selectedSlotEnd = null;
        $this->availableSlots = [];
    }

    public function previousMonth(): void
    {
        $tz = config('appointments.timezone', 'Europe/Athens');
        $date = Carbon::create($this->currentYear, $this->currentMonth, 1, 0, 0, 0, $tz)->subMonth();
        $now = Carbon::now($tz);

        if ($date->year < $now->year || ($date->year === $now->year && $date->month < $now->month)) {
            return;
        }

        $this->currentYear = $date->year;
        $this->currentMonth = $date->month;
        $this->loadMonth();
    }

    public function nextMonth(): void
    {
        $tz = config('appointments.timezone', 'Europe/Athens');
        $date = Carbon::create($this->currentYear, $this->currentMonth, 1, 0, 0, 0, $tz)->addMonth();

        $type = ConsultationType::findOrFail($this->consultationTypeId);
        $maxDate = Carbon::now($tz)->addDays($type->max_advance_days);

        if ($date->startOfMonth()->gt($maxDate)) {
            return;
        }

        $this->currentYear = $date->year;
        $this->currentMonth = $date->month;
        $this->loadMonth();
    }

    public function selectDate(string $date): void
    {
        $this->selectedDate = $date;
        $this->selectedSlotStart = null;
        $this->selectedSlotEnd = null;

        $type = ConsultationType::findOrFail($this->consultationTypeId);
        $service = app(AppointmentService::class);
        $this->availableSlots = $service->getAvailableSlots($type, Carbon::parse($date));
    }

    public function selectSlot(string $start, string $end): void
    {
        $this->selectedSlotStart = $start;
        $this->selectedSlotEnd = $end;
    }

    public function render()
    {
        $tz = config('appointments.timezone', 'Europe/Athens');
        $firstDay = Carbon::create($this->currentYear, $this->currentMonth, 1, 0, 0, 0, $tz);
        $daysInMonth = $firstDay->daysInMonth;
        $startDayOfWeek = $firstDay->dayOfWeek; // 0=Sunday
        // Convert to Monday-start: Mon=0, Tue=1, ... Sun=6
        $startOffset = ($startDayOfWeek === 0) ? 6 : $startDayOfWeek - 1;

        $calendarDays = [];
        for ($i = 0; $i < $startOffset; $i++) {
            $calendarDays[] = null; // empty cells before first day
        }
        for ($d = 1; $d <= $daysInMonth; $d++) {
            $dateStr = sprintf('%04d-%02d-%02d', $this->currentYear, $this->currentMonth, $d);
            $calendarDays[] = [
                'day' => $d,
                'date' => $dateStr,
                'available' => isset($this->availableDates[$dateStr]),
                'slots_count' => $this->availableDates[$dateStr] ?? 0,
                'selected' => $this->selectedDate === $dateStr,
            ];
        }

        $monthLabel = $firstDay->format('F Y');

        return view('livewire.appointment-slot-picker', [
            'calendarDays' => $calendarDays,
            'monthLabel' => $monthLabel,
        ]);
    }
}
