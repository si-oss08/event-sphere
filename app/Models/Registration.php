<?php

namespace App\Models;

use App\RegistrationStatus;
use Database\Factories\RegistrationFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

#[Fillable(['event_id', 'user_id', 'ticket_code', 'status', 'notes', 'checked_in_at'])]
class Registration extends Model
{
    /** @use HasFactory<RegistrationFactory> */
    use HasFactory;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'status' => RegistrationStatus::class,
            'checked_in_at' => 'datetime',
        ];
    }

    /**
     * Bootstrap the model and its traits.
     */
    protected static function booted(): void
    {
        static::creating(function (Registration $registration): void {
            $registration->ticket_code ??= static::generateTicketCode();
        });
    }

    /**
     * Get the event the registration belongs to.
     *
     * @return BelongsTo<Event, $this>
     */
    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }

    /**
     * Get the participant that owns the registration.
     *
     * @return BelongsTo<User, $this>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Generate a unique ticket code.
     */
    public static function generateTicketCode(): string
    {
        do {
            $code = 'EVS-'.Str::upper(Str::random(8));
        } while (static::query()->where('ticket_code', $code)->exists());

        return $code;
    }
}
