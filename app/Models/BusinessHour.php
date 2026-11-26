<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BusinessHour extends Model
{
    use HasFactory;

    protected $fillable = [
        'umkm_profile_id',
        'day_of_week',
        'is_closed',
        'open_time',
        'close_time',
    ];

    protected function casts(): array
    {
        return [
            'is_closed' => 'boolean',
            'day_of_week' => 'integer',
        ];
    }

    public function umkmProfile(): BelongsTo
    {
        return $this->belongsTo(UmkmProfile::class);
    }

    public static function getDayName(int $dayOfWeek): string
    {
        return match($dayOfWeek) {
            0 => 'Minggu',
            1 => 'Senin',
            2 => 'Selasa',
            3 => 'Rabu',
            4 => 'Kamis',
            5 => 'Jumat',
            6 => 'Sabtu',
            default => 'Tidak Diketahui',
        };
    }

    public function getDayNameAttribute(): string
    {
        return self::getDayName($this->day_of_week);
    }
}
