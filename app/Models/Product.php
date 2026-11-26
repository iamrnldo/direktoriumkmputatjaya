<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    const STATUS_AVAILABLE = 'available';
    const STATUS_OUT_OF_STOCK = 'out_of_stock';
    const STATUS_PREORDER = 'preorder';
    const STATUS_UNAVAILABLE = 'unavailable';

    protected $fillable = [
        'umkm_profile_id', 'product_category_id', 'name', 'slug',
        'short_description', 'description', 'price', 'price_label',
        'availability_status', 'is_featured', 'is_active', 'view_count',
    ];

    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
            'is_featured' => 'boolean',
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

    // Relations
    public function umkmProfile(): BelongsTo
    {
        return $this->belongsTo(UmkmProfile::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(ProductCategory::class, 'product_category_id');
    }

    public function images(): HasMany
    {
        return $this->hasMany(ProductImage::class)->orderBy('sort_order');
    }

    public function coverImage(): HasOne
    {
        return $this->hasOne(ProductImage::class)->where('is_cover', true);
    }

    public function favorites(): MorphMany
    {
        return $this->morphMany(Favorite::class, 'favoritable');
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeAvailable($query)
    {
        return $query->where('availability_status', self::STATUS_AVAILABLE);
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    // Helpers
    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function getFormattedPriceAttribute(): string
    {
        if ($this->price_label) {
            return $this->price_label;
        }
        if ($this->price == 0) {
            return 'Hubungi Penjual';
        }
        return 'Rp' . number_format($this->price, 0, ',', '.');
    }

    public function getCoverImageUrlAttribute(): string
    {
        $cover = $this->images->firstWhere('is_cover', true) ?? $this->images->first();
        if ($cover) {
            return asset('storage/' . $cover->image_path);
        }
        return asset('images/placeholder-product.jpg');
    }

    public function getAvailabilityLabelAttribute(): string
    {
        return match($this->availability_status) {
            'available' => 'Tersedia',
            'out_of_stock' => 'Habis',
            'preorder' => 'Pre-order',
            'unavailable' => 'Tidak Tersedia',
            default => 'Tidak Diketahui',
        };
    }

    public function getAvailabilityColorAttribute(): string
    {
        return match($this->availability_status) {
            'available' => 'green',
            'out_of_stock' => 'red',
            'preorder' => 'yellow',
            'unavailable' => 'gray',
            default => 'gray',
        };
    }

    public function getWhatsappLinkAttribute(): string
    {
        $number = preg_replace('/[^0-9]/', '', $this->umkmProfile->whatsapp_number);
        if (str_starts_with($number, '0')) {
            $number = '62' . substr($number, 1);
        }
        $message = urlencode("Halo, saya menemukan produk '{$this->name}' dari {$this->umkmProfile->name} melalui Direktori UMKM Kelurahan Putat Jaya. Saya ingin menanyakan ketersediaan produk tersebut.");
        return "https://wa.me/{$number}?text={$message}";
    }
}
