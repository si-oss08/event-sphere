<?php

namespace App;

enum EventStatus: string
{
    case Draft = 'draft';
    case Published = 'published';
    case Cancelled = 'cancelled';
    case Completed = 'completed';

    /**
     * Get the human-readable label for the status.
     */
    public function label(): string
    {
        return match ($this) {
            self::Draft => 'Draf',
            self::Published => 'Terbit',
            self::Cancelled => 'Dibatalkan',
            self::Completed => 'Selesai',
        };
    }

    /**
     * Get the Tailwind classes used to render a badge for the status.
     */
    public function badgeClasses(): string
    {
        return match ($this) {
            self::Draft => 'bg-slate-100 text-slate-700 ring-slate-600/20',
            self::Published => 'bg-emerald-100 text-emerald-700 ring-emerald-600/20',
            self::Cancelled => 'bg-rose-100 text-rose-700 ring-rose-600/20',
            self::Completed => 'bg-sky-100 text-sky-700 ring-sky-600/20',
        };
    }

    /**
     * Determine whether the event is visible to the public.
     */
    public function isVisibleToPublic(): bool
    {
        return in_array($this, [self::Published, self::Completed], true);
    }

    /**
     * Get the statuses available to organizers when creating an event.
     *
     * @return array<int, self>
     */
    public static function organisable(): array
    {
        return [self::Draft, self::Published, self::Cancelled];
    }
}
