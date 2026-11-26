<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Favorite;
use App\Models\Review;
use App\Models\UmkmCategory;
use App\Models\UmkmProfile;
use App\Services\AnalyticsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UmkmController extends Controller
{
    public function __construct(private AnalyticsService $analytics) {}

    public function index(Request $request)
    {
        $query = UmkmProfile::active()
            ->with(['category', 'images' => fn($q) => $q->where('is_cover', true)])
            ->withCount('activeProducts');

        if ($search = $request->input('q')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('owner_name', 'like', "%{$search}%")
                  ->orWhere('business_description', 'like', "%{$search}%")
                  ->orWhere('address', 'like', "%{$search}%");
            });
        }

        if ($categorySlug = $request->input('kategori')) {
            $query->whereHas('category', fn($q) => $q->where('slug', $categorySlug));
        }

        if ($request->boolean('unggulan')) {
            $query->featured();
        }

        if ($request->boolean('punya-produk')) {
            $query->has('activeProducts');
        }

        $sort = $request->input('urut', 'terbaru');
        match($sort) {
            'az'     => $query->orderBy('name'),
            'za'     => $query->orderByDesc('name'),
            'populer' => $query->orderByDesc('view_count'),
            default  => $query->latest(),
        };

        $umkmList   = $query->paginate(12)->withQueryString();
        $categories = UmkmCategory::active()
            ->withCount(['umkmProfiles' => fn($q) => $q->active()])
            ->orderBy('sort_order')
            ->get();

        $this->analytics->trackSearch($request->input('q') ?? '', $request->input('kategori'));

        return view('public.direktori-umkm', compact('umkmList', 'categories', 'sort'));
    }

    public function show(string $slug)
    {
        $umkm = UmkmProfile::where('slug', $slug)
            ->where('verification_status', 'aktif')
            ->where('is_active', true)
            ->with([
                'category',
                'images',
                'businessHours',
                'activeProducts.images',
                'featuredProducts.images',
                'reviews'       => fn($q) => $q->with('user')->latest()->limit(10),
                'verifications' => fn($q) => $q->with('admin')->latest(),
            ])
            ->withCount('reviews')
            ->withAvg('reviews', 'rating')
            ->firstOrFail();

        $this->analytics->trackProfileView($umkm->id);
        $umkm->increment('view_count');

        $isOpen = $umkm->businessHours->count() ? $umkm->isOpenNow() : null;

        $isFavorite = Auth::check()
            ? Favorite::where('user_id', Auth::id())
                ->where('favoritable_type', UmkmProfile::class)
                ->where('favoritable_id', $umkm->id)
                ->exists()
            : false;

        $umkm->setAttribute('average_rating', $umkm->reviews_avg_rating ?? 0);

        $relatedUmkm = UmkmProfile::active()
            ->where('category_id', $umkm->category_id)
            ->where('id', '!=', $umkm->id)
            ->with(['category', 'images' => fn($q) => $q->where('is_cover', true)])
            ->limit(4)
            ->get();

        return view('public.umkm-detail', compact('umkm', 'relatedUmkm', 'isOpen', 'isFavorite'));
    }

    public function storeReview(Request $request)
    {
        $request->validate([
            'umkm_profile_id' => 'required|exists:umkm_profiles,id',
            'rating'          => 'required|integer|min:1|max:5',
            'comment'         => 'nullable|string|max:1000',
        ]);

        $existing = Review::where('user_id', Auth::id())
            ->where('umkm_profile_id', $request->umkm_profile_id)
            ->first();

        if ($existing) {
            return back()->with('error', 'Anda sudah memberikan ulasan untuk UMKM ini.');
        }

        Review::create([
            'user_id'         => Auth::id(),
            'umkm_profile_id' => $request->umkm_profile_id,
            'rating'          => $request->rating,
            'comment'         => $request->comment,
            'status'          => 'approved',
        ]);

        return back()->with('success', 'Ulasan berhasil dikirim. Terima kasih!');
    }

    public function toggleFavorite(Request $request, UmkmProfile $umkm)
    {
        $user     = Auth::user();
        $existing = Favorite::where('user_id', $user->id)
            ->where('favoritable_type', UmkmProfile::class)
            ->where('favoritable_id', $umkm->id)
            ->first();

        if ($existing) {
            $existing->delete();
            return response()->json(['is_favorite' => false]);
        }

        Favorite::create([
            'user_id'          => $user->id,
            'favoritable_type' => UmkmProfile::class,
            'favoritable_id'   => $umkm->id,
        ]);

        return response()->json(['is_favorite' => true]);
    }
}
