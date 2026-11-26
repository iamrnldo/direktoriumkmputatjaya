<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Event;

class EventController extends Controller
{
    public function index()
    {
        $events = Event::active()
            ->upcoming()
            ->paginate(9);

        return view('public.event', compact('events'));
    }

    public function show(string $slug)
    {
        $event = Event::where('slug', $slug)->where('is_active', true)->firstOrFail();
        return view('public.event-detail', compact('event'));
    }
}
