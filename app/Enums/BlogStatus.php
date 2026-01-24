<?php

namespace App\Enums;

enum BlogStatus: string
{
    case DRAFT = 'draft';
    case PENDING = 'pending';
    case APPROVED = 'approved';
    case REJECTED = 'rejected';

    /**
     * Get human-readable label for the status.
     */
    public function label(): string
    {
        return match($this) {
            self::DRAFT => 'Draft',
            self::PENDING => 'Pending Review',
            self::APPROVED => 'Approved',
            self::REJECTED => 'Rejected',
        };
    }

    /**
     * Get CSS color class for the status.
     */
    public function color(): string
    {
        return match($this) {
            self::DRAFT => 'gray',
            self::PENDING => 'yellow',
            self::APPROVED => 'green',
            self::REJECTED => 'red',
        };
    }

    /**
     * Get badge HTML for the status.
     */
    public function badge(): string
    {
        $color = $this->color();
        $label = $this->label();

        return "<span class='px-3 py-1 inline-flex text-xs font-bold rounded-full bg-{$color}-100 text-{$color}-800'>{$label}</span>";
    }

    /**
     * Check if blog can be edited in this status.
     */
    public function canBeEdited(): bool
    {
        return in_array($this, [self::DRAFT, self::REJECTED]);
    }

    /**
     * Check if blog can be submitted for review.
     */
    public function canBeSubmitted(): bool
    {
        return $this === self::DRAFT;
    }

    /**
     * Check if blog can be withdrawn from review.
     */
    public function canBeWithdrawn(): bool
    {
        return $this === self::PENDING;
    }

    /**
     * Get all statuses as array for dropdowns.
     */
    public static function toArray(): array
    {
        return array_map(fn($status) => [
            'value' => $status->value,
            'label' => $status->label(),
            'color' => $status->color(),
        ], self::cases());
    }
}
