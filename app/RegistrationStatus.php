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
            self::Pending => 'bg-zinc-500/10 text-zinc-300 ring-zinc-500/30',
            self::Confirmed => 'bg-accent/10 text-accent-soft ring-accent/30',
            self::Cancelled => 'bg-danger/10 text-rose-300 ring-danger/30',
            self::Attended => 'bg-zinc-500/10 text-zinc-200 ring-zinc-500/30',
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
