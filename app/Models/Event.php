<?php

namespace App\Models;

use App\EventStatus;
use Database\Factories\EventFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

#[Fillable([
    'organizer_id',
    'category_id',
    'title',
    'slug',
    'description',
    'venue',
    'city',
    'address',
    'starts_at',
    'ends_at',
    'capacity',
    'price',
    'poster_path',
    'status',
    'featured',
])]
class Event extends Model
{
    /** @use HasFactory<EventFactory> */
    use HasFactory;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'starts_at' => 'datetime',
            'ends_at' => 'datetime',
            'price' => 'decimal:2',
            'capacity' => 'integer',
            'featured' => 'boolean',
            'status' => EventStatus::class,
        ];
    }

    /**
     * Bootstrap the model and its traits.
     */
    protected static function booted(): void
    {
        static::creating(function (Event $event): void {
            $event->slug ??= static::uniqueSlug($event->title);
        });
    }

    /**
     * Get the user that organizes the event.
     *
     * @return BelongsTo<User, $this>
     */
    public function organizer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'organizer_id');
    }

    /**
     * Get the category the event belongs to.
     *
     * @return BelongsTo<Category, $this>
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get the registrations for the event.
     *
     * @return HasMany<Registration, $this>
     */
    public function registrations(): HasMany
    {
        return $this->hasMany(Registration::class);
    }

    /**
     * Scope the query to events visible on the public site.
     *
     * @param  Builder<Event>  $query
     */
    public function scopeVisible(Builder $query): void
    {
        $query->whereIn('status', [EventStatus::Published->value, EventStatus::Completed->value]);
    }

    /**
     * Scope the query to events that have not started yet.
     *
     * @param  Builder<Event>  $query
     */
    public function scopeUpcoming(Builder $query): void
    {
        $query->where('ends_at', '>=', now());
    }

    /**
     * Scope the query to featured events.
     *
     * @param  Builder<Event>  $query
     */
    public function scopeFeatured(Builder $query): void
    {
        $query->where('featured', true);
    }

    /**
     * Get the number of seats occupied by active registrations.
     */
    public function seatsTaken(): int
    {
        if (array_key_exists('active_registrations_count', $this->attributes)) {
            return (int) $this->attributes['active_registrations_count'];
        }

        return $this->registrations()->whereIn('status', ['pending', 'confirmed', 'attended'])->count();
    }

    /**
     * Get the number of seats still available.
     */
    public function seatsRemaining(): int
    {
        return max(0, $this->capacity - $this->seatsTaken());
    }

    /**
     * Determine whether the event is fully booked.
     */
    public function isSoldOut(): bool
    {
        return $this->seatsRemaining() === 0;
    }

    /**
     * Determine whether the event is free to attend.
     */
    public function isFree(): bool
    {
        return (float) $this->price <= 0;
    }

    /**
     * Get the formatted ticket price.
     */
    public function formattedPrice(): string
    {
        return $this->isFree() ? 'Gratis' : 'Rp '.number_format((float) $this->price, 0, ',', '.');
    }

    /**
     * Get the percentage of seats that have been taken.
     */
    public function occupancyPercentage(): int
    {
        if ($this->capacity === 0) {
            return 0;
        }

        return (int) min(100, round($this->seatsTaken() / $this->capacity * 100));
    }

    /**
     * Get the public URL of the event poster.
     */
    public function posterUrl(): string
    {
        if ($this->poster_path) {
            return Str::startsWith($this->poster_path, ['http://', 'https://'])
                ? $this->poster_path
                : asset('storage/'.$this->poster_path);
        }

        return 'https://picsum.photos/seed/eventsphere-'.$this->id.'/800/500';
    }

    /**
     * Determine whether the event has finished.
     */
    public function hasFinished(): bool
    {
        return $this->ends_at->isPast();
    }

    /**
     * Generate a unique slug for the given title.
     */
    public static function uniqueSlug(string $title, ?int $ignoreId = null): string
    {
        $base = Str::slug($title) ?: 'event';
        $slug = $base;
        $counter = 2;

        while (static::query()->where('slug', $slug)->when($ignoreId, fn ($query) => $query->whereKeyNot($ignoreId))->exists()) {
            $slug = $base.'-'.$counter++;
        }

        return $slug;
    }
}
