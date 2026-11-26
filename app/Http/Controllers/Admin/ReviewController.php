<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function index(Request $request)
    {
        $query = Review::with(['user', 'umkmProfile'])->withTrashed();

        if ($status = $request->input('status')) {
            $query->where('status', $status);
        }

        $reviews = $query->latest()->paginate(20)->withQueryString();
        return view('admin.ulasan', compact('reviews'));
    }

    public function approve(Review $review)
    {
        $review->update(['status' => 'approved', 'reviewed_by' => Auth::id(), 'reviewed_at' => now()]);
        return back()->with('success', 'Ulasan berhasil disetujui.');
    }

    public function reject(Review $review)
    {
        $review->update(['status' => 'rejected', 'reviewed_by' => Auth::id(), 'reviewed_at' => now()]);
        return back()->with('success', 'Ulasan berhasil ditolak.');
    }
}
