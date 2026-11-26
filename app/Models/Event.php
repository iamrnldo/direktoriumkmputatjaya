<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Event extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title', 'slug', 'description', 'cover_image',
        'event_date', 'start_time', 'end_time',
        'location_name', 'address', 'latitude', 'longitude',
        'cta_url', 'is_active', 'created_by',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'event_date' => 'datetime',
            'latitude' => 'decimal:8',
            'longitude' => 'decimal:8',
        ];
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->slug = $model->makeUniqueSlug($model->title);
        });

        static::updating(function ($model) {
            if ($model->isDirty('title')) {
                $model->slug = $model->makeUniqueSlug($model->title, $model->getKey());
            }
        });
    }

    protected function makeUniqueSlug(string $title, int|string|null $ignoreId = null): string
    {
        $base = Str::slug($title) ?: 'event';
        $candidate = $base;
        $suffix = 2;

        while (static::withTrashed()
            ->where('slug', $candidate)
            ->when($ignoreId !== null, fn ($query) => $query->where($this->getKeyName(), '<>', $ignoreId))
            ->exists()) {
            $candidate = $base . '-' . $suffix++;
        }

        return $candidate;
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeUpcoming($query)
    {
        // event_date is stored at midnight while start/end time live in separate columns.
        // Keep today's events visible for the full calendar day and hide only past dates.
        return $query->whereDate('event_date', '>=', now()->toDateString())
            ->orderBy('event_date')
            ->orderBy('start_time');
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function getCoverImageUrlAttribute(): string
    {
        if ($this->cover_image) {
            return asset('storage/' . $this->cover_image);
        }
        return asset('images/placeholder-event.jpg');
    }
}
