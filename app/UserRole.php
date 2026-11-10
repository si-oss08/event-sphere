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
            self::Admin => 'bg-rose-100 text-rose-700 ring-rose-600/20',
            self::Organizer => 'bg-violet-100 text-violet-700 ring-violet-600/20',
            self::Participant => 'bg-sky-100 text-sky-700 ring-sky-600/20',
        };
    }
}
