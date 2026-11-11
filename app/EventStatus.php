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
            self::Draft => 'bg-zinc-500/10 text-zinc-300 ring-zinc-500/30',
            self::Published => 'bg-accent/10 text-accent-soft ring-accent/30',
            self::Cancelled => 'bg-danger/10 text-rose-300 ring-danger/30',
            self::Completed => 'bg-zinc-500/10 text-zinc-300 ring-zinc-500/30',
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
