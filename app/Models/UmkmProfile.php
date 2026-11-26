<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class UmkmProfile extends Model
{
    use HasFactory, SoftDeletes;

    const STATUS_DRAFT = 'draft';
    const STATUS_DIAJUKAN = 'diajukan';
    const STATUS_PERLU_REVISI = 'perlu_revisi';
    const STATUS_TERVERIFIKASI = 'terverifikasi';
    const STATUS_AKTIF = 'aktif';
    const STATUS_DITOLAK = 'ditolak';
    const STATUS_NONAKTIF = 'nonaktif';

    protected $fillable = [
        'user_id', 'category_id', 'name', 'slug', 'owner_name', 'owner_nik', 'owner_rt', 'owner_rw',
        'business_description', 'address', 'village', 'district',
        'city', 'province', 'postal_code', 'whatsapp_number',
        'business_email', 'website_url', 'instagram_url', 'facebook_url',
        'tiktok_url', 'shopee_url', 'tokopedia_url', 'marketplace_url',
        'latitude', 'longitude', 'verification_status', 'verification_notes',
        'is_featured', 'is_active', 'verified_at', 'activated_at',
        'created_by', 'updated_by',
    ];

    protected function casts(): array
    {
        return [
            'is_featured' => 'boolean',
            'is_active' => 'boolean',
            'verified_at' => 'datetime',
            'activated_at' => 'datetime',
            'latitude' => 'decimal:8',
            'longitude' => 'decimal:8',
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
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(UmkmCategory::class, 'category_id');
    }

    public function businessHours(): HasMany
    {
        return $this->hasMany(BusinessHour::class)->orderBy('day_of_week');
    }

    public function images(): HasMany
    {
        return $this->hasMany(UmkmImage::class)->orderBy('sort_order');
    }

    public function coverImage(): HasOne
    {
        return $this->hasOne(UmkmImage::class)->where('is_cover', true);
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    public function activeProducts(): HasMany
    {
        return $this->hasMany(Product::class)->where('is_active', true);
    }

    public function featuredProducts(): HasMany
    {
        return $this->hasMany(Product::class)->where('is_featured', true)->where('is_active', true);
    }

    public function verifications(): HasMany
    {
        return $this->hasMany(UmkmVerification::class)->latest();
    }

    public function latestVerification(): HasOne
    {
        return $this->hasOne(UmkmVerification::class)->latestOfMany();
    }

    public function changeRequests(): HasMany
    {
        return $this->hasMany(UmkmChangeRequest::class)->latest();
    }

    public function analyticsEvents(): HasMany
    {
        return $this->hasMany(AnalyticsEvent::class);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class)->where('status', 'approved');
    }

    public function favorites(): MorphMany
    {
        return $this->morphMany(Favorite::class, 'favoritable');
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updatedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('verification_status', self::STATUS_AKTIF)->where('is_active', true);
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeWithValidCoordinates($query)
    {
        return $query->whereNotNull('latitude')
            ->whereNotNull('longitude')
            ->whereBetween('latitude', [-90, 90])
            ->whereBetween('longitude', [-180, 180]);
    }

    // Helpers
    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function resolveRouteBinding($value, $field = null)
    {
        if ($field) {
            return $this->where($field, $value)->first();
        }

        if (is_numeric($value)) {
            $found = $this->where('id', $value)->first();
            if ($found) {
                return $found;
            }
        }

        return $this->where('slug', $value)->first();
    }

    public function getWhatsappLinkAttribute(): string
    {
        $number = preg_replace('/[^0-9]/', '', $this->whatsapp_number);
        if (str_starts_with($number, '0')) {
            $number = '62' . substr($number, 1);
        }
        $message = urlencode("Halo, saya menemukan usaha Anda melalui Direktori UMKM Kelurahan Putat Jaya. Saya ingin menanyakan informasi mengenai {$this->name}.");
        return "https://wa.me/{$number}?text={$message}";
    }

    public function getGoogleMapsLinkAttribute(): string
    {
        if ($this->latitude && $this->longitude) {
            return "https://www.google.com/maps/search/?api=1&query={$this->latitude},{$this->longitude}";
        }
        return "https://www.google.com/maps/search/?api=1&query=" . urlencode($this->address . ', Putat Jaya, Surabaya');
    }

    public function isOpenNow(): bool
    {
        $now = Carbon::now('Asia/Jakarta');
        $dayOfWeek = $now->dayOfWeek; // 0=Sunday, 1=Monday, ...
        $currentTime = $now->format('H:i:s');

        $hours = $this->businessHours->firstWhere('day_of_week', $dayOfWeek);

        if (!$hours || $hours->is_closed) {
            return false;
        }

        if ($hours->open_time && $hours->close_time) {
            return $currentTime >= $hours->open_time && $currentTime <= $hours->close_time;
        }

        return true;
    }

    public function getCoverImageUrlAttribute(): ?string
    {
        $cover = $this->images->firstWhere('is_cover', true) ?? $this->images->first();
        if ($cover && Storage::disk('public')->exists($cover->image_path)) {
            return asset('storage/' . $cover->image_path);
        }
        return null;
    }

    public function getStatusBadgeColorAttribute(): string
    {
        return match($this->verification_status) {
            'draft' => 'gray',
            'diajukan' => 'yellow',
            'perlu_revisi' => 'orange',
            'terverifikasi' => 'blue',
            'aktif' => 'green',
            'ditolak' => 'red',
            'nonaktif' => 'gray',
            default => 'gray',
        };
    }

    public function getStatusLabelAttribute(): string
    {
        return match($this->verification_status) {
            'draft' => 'Draft',
            'diajukan' => 'Diajukan',
            'perlu_revisi' => 'Perlu Revisi',
            'terverifikasi' => 'Terverifikasi',
            'aktif' => 'Aktif',
            'ditolak' => 'Ditolak',
            'nonaktif' => 'Nonaktif',
            default => 'Tidak Diketahui',
        };
    }

    public function hasValidCoordinates(): bool
    {
        return $this->latitude !== null
            && $this->longitude !== null
            && $this->latitude >= -90 && $this->latitude <= 90
            && $this->longitude >= -180 && $this->longitude <= 180;
    }
}
