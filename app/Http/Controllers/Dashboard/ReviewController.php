<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Review;
use App\Models\UmkmProfile;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function index()
    {
        $umkm = UmkmProfile::where('user_id', Auth::id())->firstOrFail();

        $reviews = Review::where('umkm_profile_id', $umkm->id)
            ->with('user')
            ->latest()
            ->paginate(10);

        $stats = [
            'total' => Review::where('umkm_profile_id', $umkm->id)->count(),
            'average' => round(Review::where('umkm_profile_id', $umkm->id)->avg('rating') ?? 0, 1),
            'distribution' => [],
        ];

        for ($i = 5; $i >= 1; $i--) {
            $count = Review::where('umkm_profile_id', $umkm->id)->where('rating', $i)->count();
            $stats['distribution'][$i] = [
                'count' => $count,
                'percent' => $stats['total'] > 0 ? round($count / $stats['total'] * 100) : 0,
            ];
        }

        return view('dashboard.ulasan', compact('umkm', 'reviews', 'stats'));
    }
}
