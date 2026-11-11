<?php

namespace App;

enum UserRole: string
{
    case Admin = 'admin';
    case Organizer = 'organizer';
    case Participant = 'participant';

    /**
     * Get the human-readable label for the role.
     */
    public function label(): string
    {
        return match ($this) {
            self::Admin => 'Administrator',
            self::Organizer => 'Penyelenggara',
            self::Participant => 'Peserta',
        };
    }

    /**
     * Get the Tailwind classes used to render a badge for the role.
     */
    public function badgeClasses(): string
    {
        return match ($this) {
            self::Admin => 'bg-accent/15 text-accent ring-accent/40',
            self::Organizer => 'bg-accent/[0.06] text-accent-soft ring-accent/25',
            self::Participant => 'bg-zinc-500/10 text-zinc-300 ring-zinc-500/30',
        };
    }
}
