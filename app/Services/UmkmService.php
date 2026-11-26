<?php

namespace App\Services;

use App\Models\AuditLog;
use App\Models\BusinessHour;
use App\Models\UmkmImage;
use App\Models\UmkmProfile;
use App\Models\UmkmVerification;
use App\Notifications\UmkmApproved;
use App\Notifications\UmkmRejected;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Str;

class UmkmService
{
    public function create(array $data, ?int $userId = null): UmkmProfile
    {
        return DB::transaction(function () use ($data, $userId) {
            $slug = $this->generateUniqueSlug($data['name']);

            $profile = UmkmProfile::create([
                'user_id' => $userId ?? Auth::id(),
                'category_id' => $data['category_id'],
                'name' => $data['name'],
                'slug' => $slug,
                'owner_name' => $data['owner_name'],
                'business_description' => $data['business_description'] ?? null,
                'address' => $data['address'],
                'village' => $data['village'] ?? 'Putat Jaya',
                'district' => $data['district'] ?? 'Sawahan',
                'city' => $data['city'] ?? 'Surabaya',
                'province' => $data['province'] ?? 'Jawa Timur',
                'postal_code' => $data['postal_code'] ?? null,
                'whatsapp_number' => $data['whatsapp_number'],
                'business_email' => $data['business_email'] ?? null,
                'website_url' => $data['website_url'] ?? null,
                'instagram_url' => $data['instagram_url'] ?? null,
                'facebook_url' => $data['facebook_url'] ?? null,
                'tiktok_url' => $data['tiktok_url'] ?? null,
                'shopee_url' => $data['shopee_url'] ?? null,
                'tokopedia_url' => $data['tokopedia_url'] ?? null,
                'marketplace_url' => $data['marketplace_url'] ?? null,
                'latitude' => $data['latitude'] ?? null,
                'longitude' => $data['longitude'] ?? null,
                'verification_status' => UmkmProfile::STATUS_DRAFT,
                'is_featured' => false,
                'is_active' => false,
                'created_by' => Auth::id(),
                'updated_by' => Auth::id(),
            ]);

            // Initialize default business hours
            $this->initializeBusinessHours($profile);

            $this->auditLog('create_umkm', $profile, null, $profile->toArray());

            return $profile;
        });
    }

    public function update(UmkmProfile $profile, array $data): UmkmProfile
    {
        return DB::transaction(function () use ($profile, $data) {
            $old = $profile->toArray();

            $profile->update(array_merge($data, [
                'updated_by' => Auth::id(),
            ]));

            $this->auditLog('update_umkm', $profile, $old, $profile->fresh()->toArray());

            return $profile->fresh();
        });
    }

    public function submitForVerification(UmkmProfile $profile): void
    {
        DB::transaction(function () use ($profile) {
            $profile->update([
                'verification_status' => UmkmProfile::STATUS_DIAJUKAN,
                'updated_by' => Auth::id(),
            ]);
            $this->auditLog('submit_verification', $profile, null, ['status' => UmkmProfile::STATUS_DIAJUKAN]);
        });
    }

    public function approve(UmkmProfile $profile, ?string $notes = null): void
    {
        DB::transaction(function () use ($profile, $notes) {
            $old = ['verification_status' => $profile->verification_status];

            $profile->update([
                'verification_status' => UmkmProfile::STATUS_AKTIF,
                'is_active' => true,
                'verified_at' => now(),
                'activated_at' => now(),
                'verification_notes' => $notes,
                'updated_by' => Auth::id(),
            ]);

            UmkmVerification::create([
                'umkm_profile_id' => $profile->id,
                'admin_id' => Auth::id(),
                'status' => 'approved',
                'notes' => $notes,
                'verified_at' => now(),
            ]);

            $this->auditLog('approve_umkm', $profile, $old, ['verification_status' => UmkmProfile::STATUS_AKTIF]);

            // Kirim notifikasi email ke pemilik UMKM
            if ($profile->user) {
                $profile->user->notify(new UmkmApproved($profile, $notes));
            }
        });
    }

    public function reject(UmkmProfile $profile, string $notes): void
    {
        DB::transaction(function () use ($profile, $notes) {
            $old = ['verification_status' => $profile->verification_status];

            $profile->update([
                'verification_status' => UmkmProfile::STATUS_DITOLAK,
                'is_active' => false,
                'verification_notes' => $notes,
                'updated_by' => Auth::id(),
            ]);

            UmkmVerification::create([
                'umkm_profile_id' => $profile->id,
                'admin_id' => Auth::id(),
                'status' => 'rejected',
                'notes' => $notes,
                'verified_at' => now(),
            ]);

            $this->auditLog('reject_umkm', $profile, $old, [
                'verification_status' => UmkmProfile::STATUS_DITOLAK,
                'notes' => $notes,
            ]);

            // Kirim notifikasi email penolakan ke pemilik UMKM
            if ($profile->user) {
                $profile->user->notify(new UmkmRejected($profile, $notes));
            }
        });
    }

    public function requestRevision(UmkmProfile $profile, string $notes): void
    {
        DB::transaction(function () use ($profile, $notes) {
            $profile->update([
                'verification_status' => UmkmProfile::STATUS_PERLU_REVISI,
                'verification_notes' => $notes,
                'updated_by' => Auth::id(),
            ]);

            UmkmVerification::create([
                'umkm_profile_id' => $profile->id,
                'admin_id' => Auth::id(),
                'status' => 'revision_requested',
                'notes' => $notes,
                'verified_at' => now(),
            ]);

            $this->auditLog('request_revision_umkm', $profile, null, [
                'verification_status' => UmkmProfile::STATUS_PERLU_REVISI,
                'notes' => $notes,
            ]);
        });
    }

    public function toggleFeatured(UmkmProfile $profile): void
    {
        $profile->update(['is_featured' => !$profile->is_featured]);
        $this->auditLog('toggle_featured_umkm', $profile, null, ['is_featured' => $profile->fresh()->is_featured]);
    }

    public function uploadImages(UmkmProfile $profile, array $files): void
    {
        $hasExistingImages = $profile->images()->count() > 0;
        $sortOrder = $profile->images()->max('sort_order') ?? 0;

        foreach ($files as $index => $file) {
            if (!$file instanceof UploadedFile) continue;

            try {
                $path = $file->store('umkm/' . $profile->id . '/images', 'public');
            } catch (\Throwable $exception) {
                report($exception);
                throw ValidationException::withMessages(['images' => 'Foto gagal disimpan. Periksa izin tulis pada storage/app/public.']);
            }
            if (! $path) {
                throw ValidationException::withMessages(['images' => 'Foto gagal disimpan ke penyimpanan publik.']);
            }
            $sortOrder++;

            UmkmImage::create([
                'umkm_profile_id' => $profile->id,
                'image_path' => $path,
                'alt_text' => $profile->name,
                'sort_order' => $sortOrder,
                'is_cover' => (!$hasExistingImages && $index === 0),
            ]);
        }
    }

    public function deleteImage(UmkmImage $image): void
    {
        $wasCover = $image->is_cover;
        Storage::disk('public')->delete($image->image_path);
        $image->delete();

        if ($wasCover) {
            $first = $image->umkmProfile->images()->first();
            $first?->update(['is_cover' => true]);
        }
    }

    public function setCoverImage(UmkmImage $image): void
    {
        $image->umkmProfile->images()->update(['is_cover' => false]);
        $image->update(['is_cover' => true]);
    }

    public function updateBusinessHours(UmkmProfile $profile, array $hours): void
    {
        foreach ($hours as $dayOfWeek => $data) {
            $isClosed = !empty($data['is_closed']);

            BusinessHour::updateOrCreate(
                ['umkm_profile_id' => $profile->id, 'day_of_week' => $dayOfWeek],
                [
                    'is_closed' => $isClosed,
                    'open_time' => $isClosed ? null : ($data['open_time'] ?? null),
                    'close_time' => $isClosed ? null : ($data['close_time'] ?? null),
                ]
            );
        }
    }

    public function updateLocation(UmkmProfile $profile, float $lat, float $lng): void
    {
        $profile->update(['latitude' => $lat, 'longitude' => $lng, 'updated_by' => Auth::id()]);
    }

    public function softDelete(UmkmProfile $profile): void
    {
        DB::transaction(function () use ($profile) {
            $this->auditLog('delete_umkm', $profile, $profile->toArray(), null);
            $profile->delete();
        });
    }

    private function generateUniqueSlug(string $name): string
    {
        $slug = Str::slug($name);
        $base = $slug;
        $i = 1;
        while (UmkmProfile::where('slug', $slug)->exists()) {
            $slug = $base . '-' . $i++;
        }
        return $slug;
    }

    private function initializeBusinessHours(UmkmProfile $profile): void
    {
        for ($day = 0; $day <= 6; $day++) {
            BusinessHour::create([
                'umkm_profile_id' => $profile->id,
                'day_of_week' => $day,
                'is_closed' => ($day === 0), // Sunday closed by default
                'open_time' => ($day !== 0) ? '08:00:00' : null,
                'close_time' => ($day !== 0) ? '17:00:00' : null,
            ]);
        }
    }

    private function auditLog(string $action, UmkmProfile $profile, ?array $old, ?array $new): void
    {
        AuditLog::create([
            'user_id' => Auth::id(),
            'action' => $action,
            'subject_type' => UmkmProfile::class,
            'subject_id' => $profile->id,
            'old_values' => $old,
            'new_values' => $new,
            'ip_hash' => md5(request()->ip()),
            'user_agent' => request()->userAgent(),
            'created_at' => now(),
        ]);
    }
}
