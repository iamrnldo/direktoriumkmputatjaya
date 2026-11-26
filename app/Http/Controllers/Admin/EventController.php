<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class EventController extends Controller
{
    public function index()
    {
        $events = Event::orderByDesc('event_date')->paginate(15);
        return view('admin.event.index', compact('events'));
    }

    public function create()
    {
        return view('admin.event.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'event_date' => ['required', 'date'],
            'start_time' => ['nullable', 'date_format:H:i'],
            'end_time' => ['nullable', 'date_format:H:i'],
            'location_name' => ['nullable', 'string', 'max:255'],
            'address' => ['nullable', 'string', 'max:500'],
            'cover_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
        ]);

        $data = $request->except('cover_image');
        $data['slug'] = Str::slug($request->title);
        $data['created_by'] = Auth::id();
        $data['is_active'] = $request->boolean('is_active', true);

        if ($request->hasFile('cover_image')) {
            $data['cover_image'] = $request->file('cover_image')->store('events', 'public');
        }

        Event::create($data);
        return redirect()->route('admin.event.index')->with('success', 'Event berhasil ditambahkan.');
    }

    public function edit(Event $event)
    {
        return view('admin.event.edit', compact('event'));
    }

    public function update(Request $request, Event $event)
    {
        $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'event_date' => ['required', 'date'],
            'cover_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
        ]);

        $data = $request->except('cover_image');
        $data['is_active'] = $request->boolean('is_active');

        if ($request->hasFile('cover_image')) {
            if ($event->cover_image) {
                Storage::disk('public')->delete($event->cover_image);
            }
            $data['cover_image'] = $request->file('cover_image')->store('events', 'public');
        }

        $event->update($data);
        return redirect()->route('admin.event.index')->with('success', 'Event berhasil diperbarui.');
    }

    public function destroy(Event $event)
    {
        if ($event->cover_image) {
            Storage::disk('public')->delete($event->cover_image);
        }
        $event->delete();
        return redirect()->route('admin.event.index')->with('success', 'Event berhasil dihapus.');
    }
}
