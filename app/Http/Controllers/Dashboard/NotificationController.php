<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = Auth::user()->notifications()->paginate(15);
        return view('dashboard.notifikasi', compact('notifications'));
    }

    public function markRead(string $id)
    {
        Auth::user()->notifications()->where('id', $id)->first()?->markAsRead();
        return back()->with('success', 'Notifikasi ditandai telah dibaca.');
    }
}
