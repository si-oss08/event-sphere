<?php

namespace App;

enum RegistrationStatus: string
{
    case Pending = 'pending';
    case Confirmed = 'confirmed';
    case Cancelled = 'cancelled';
    case Attended = 'attended';

    /**
     * Get the human-readable label for the status.
     */
    public function label(): string
    {
        return match ($this) {
            self::Pending => 'Menunggu Konfirmasi',
            self::Confirmed => 'Terkonfirmasi',
            self::Cancelled => 'Dibatalkan',
            self::Attended => 'Hadir',
        };
    }

    /**
     * Get the Tailwind classes used to render a badge for the status.
     */
    public function badgeClasses(): string
    {
        return match ($this) {
            self::Pending => 'bg-amber-100 text-amber-700 ring-amber-600/20',
            self::Confirmed => 'bg-emerald-100 text-emerald-700 ring-emerald-600/20',
            self::Cancelled => 'bg-rose-100 text-rose-700 ring-rose-600/20',
            self::Attended => 'bg-sky-100 text-sky-700 ring-sky-600/20',
        };
    }

    /**
     * Determine whether the registration occupies a seat.
     */
    public function occupiesSeat(): bool
    {
        return in_array($this, [self::Pending, self::Confirmed, self::Attended], true);
    }
}
