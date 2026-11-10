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
            self::Admin => 'bg-amber-500/10 text-amber-300 ring-amber-500/30',
            self::Organizer => 'bg-emerald-500/10 text-emerald-300 ring-emerald-500/30',
            self::Participant => 'bg-zinc-500/10 text-zinc-300 ring-zinc-500/30',
        };
    }
}
