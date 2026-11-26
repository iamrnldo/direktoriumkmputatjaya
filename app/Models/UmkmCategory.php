<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class UmkmCategory extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'icon',
        'color_code',
        'marker_color',
        'is_active',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'deleted_at' => 'datetime',
        ];
    }

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            if (empty($model->slug)) {
                $model->slug = Str::slug($model->name);
            }
        });
    }

    public function umkmProfiles(): HasMany
    {
        return $this->hasMany(UmkmProfile::class, 'category_id');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function getIconEmojiAttribute(): string
    {
        return match($this->slug) {
            'kuliner' => '🍲',
            'fashion' => '👕',
            'jasa' => '🛠️',
            'perdagangan' => '🏪',
            'kerajinan' => '🎨',
            'digital' => '💻',
            'pertanian' => '🌱',
            'usaha-rumahan' => '🏠',
            default => '🏪',
        };
    }

    public function getIconAttribute($value): string
    {
        if (empty($value) || in_array($value, ['utensils', 'shirt', 'wrench', 'store', 'palette', 'laptop', 'sprout', 'home'])) {
            return $this->icon_emoji;
        }
        return $value;
    }
}
