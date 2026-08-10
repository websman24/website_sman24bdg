<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class EventController extends Controller
{
    public function index(): View
    {
        $events = Event::latest('start_date')->paginate(10);
        return view('admin.events.index', compact('events'));
    }

    public function create(): View
    {
        return view('admin.events.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'location' => ['required', 'string', 'max:255'],
            'start_date' => ['required', 'date'],
            'description' => ['nullable', 'string'],
            'status' => ['required', 'in:upcoming,ongoing,completed,cancelled'],
        ]);

        $validated['author_id'] = auth()->id();
        $validated['slug'] = Str::slug($validated['title']) . '-' . Str::random(5);

        Event::create($validated);

        return redirect()->route('admin.events.index')
            ->with('success', 'Agenda sekolah berhasil ditambahkan.');
    }

    public function edit(Event $event): View
    {
        return view('admin.events.edit', compact('event'));
    }

    public function update(Request $request, Event $event): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'location' => ['required', 'string', 'max:255'],
            'start_date' => ['required', 'date'],
            'description' => ['nullable', 'string'],
            'status' => ['required', 'in:upcoming,ongoing,completed,cancelled'],
        ]);

        if ($validated['title'] !== $event->title) {
            $validated['slug'] = Str::slug($validated['title']) . '-' . Str::random(5);
        }

        $event->update($validated);

        return redirect()->route('admin.events.index')
            ->with('success', 'Agenda sekolah berhasil diperbarui.');
    }

    public function destroy(Event $event): RedirectResponse
    {
        $event->delete();
        return redirect()->route('admin.events.index')->with('success', 'Agenda berhasil dihapus.');
    }
}
