<?php

namespace App\Enums;

enum ApplicationStatus: string
{
    case PENDING = 'pending';
    case UNDER_REVIEW = 'under_review';
    case SHORTLISTED = 'shortlisted';
    case INTERVIEWED = 'interviewed';
    case OFFERED = 'offered';
    case ACCEPTED = 'accepted';
    case REJECTED = 'rejected';
    case WITHDRAWN = 'withdrawn';

    /**
     * Get human-readable label for the status.
     */
    public function label(): string
    {
        return match($this) {
            self::PENDING => 'Pending',
            self::UNDER_REVIEW => 'Under Review',
            self::SHORTLISTED => 'Shortlisted',
            self::INTERVIEWED => 'Interviewed',
            self::OFFERED => 'Offered',
            self::ACCEPTED => 'Accepted',
            self::REJECTED => 'Rejected',
            self::WITHDRAWN => 'Withdrawn',
        };
    }

    /**
     * Get CSS color class for the status.
     */
    public function color(): string
    {
        return match($this) {
            self::PENDING => 'gray',
            self::UNDER_REVIEW => 'blue',
            self::SHORTLISTED => 'indigo',
            self::INTERVIEWED => 'purple',
            self::OFFERED => 'yellow',
            self::ACCEPTED => 'green',
            self::REJECTED => 'red',
            self::WITHDRAWN => 'gray',
        };
    }

    /**
     * Check if status can be withdrawn.
     */
    public function canBeWithdrawn(): bool
    {
        return in_array($this, [
            self::PENDING,
            self::UNDER_REVIEW,
        ]);
    }

    /**
     * Get all statuses as array for dropdowns.
     */
    public static function toArray(): array
    {
        return array_map(fn($status) => [
            'value' => $status->value,
            'label' => $status->label(),
        ], self::cases());
    }
}
