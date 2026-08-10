<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Services\FileStorageService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class EventController extends Controller
{
    public function __construct(
        protected FileStorageService $fileStorageService
    ) {}

    /**
     * Display a listing of agenda events with search and status filter.
     */
    public function index(Request $request): View
    {
        $search = $request->query('search');
        $status = $request->query('status');

        $query = Event::with('author');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('location', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        if ($status) {
            $query->where('status', $status);
        }

        $events = $query->orderBy('start_date', 'asc')->paginate(10)->withQueryString();

        return view('admin.events.index', compact('events', 'search', 'status'));
    }

    /**
     * Show form to create event.
     */
    public function create(): View
    {
        return view('admin.events.create');
    }

    /**
     * Store event record.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'location' => ['required', 'string', 'max:255'],
            'start_date' => ['required', 'date'],
            'end_date' => ['nullable', 'date', 'after_or_equal:start_date'],
            'description' => ['nullable', 'string'],
            'status' => ['required', 'in:upcoming,ongoing,completed,cancelled'],
            'banner_file' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ], [
            'title.required' => 'Judul agenda kegiatan wajib diisi.',
            'location.required' => 'Lokasi kegiatan wajib diisi.',
            'start_date.required' => 'Waktu dan tanggal kegiatan wajib diisi.',
            'banner_file.image' => 'Banner harus berupa berkas gambar.',
        ]);

        $validated['author_id'] = auth()->id();
        $validated['slug'] = Str::slug($validated['title']) . '-' . Str::random(5);

        if ($request->hasFile('banner_file')) {
            $validated['banner'] = $this->fileStorageService->uploadImage($request->file('banner_file'), 'events');
            unset($validated['banner_file']);
        }

        Event::create($validated);

        return redirect()->route('admin.events.index')
            ->with('success', 'Agenda sekolah berhasil ditambahkan.');
    }

    /**
     * Show form to edit event.
     */
    public function edit(Event $event): View
    {
        return view('admin.events.edit', compact('event'));
    }

    /**
     * Update event record.
     */
    public function update(Request $request, Event $event): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'location' => ['required', 'string', 'max:255'],
            'start_date' => ['required', 'date'],
            'end_date' => ['nullable', 'date', 'after_or_equal:start_date'],
            'description' => ['nullable', 'string'],
            'status' => ['required', 'in:upcoming,ongoing,completed,cancelled'],
            'banner_file' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ], [
            'title.required' => 'Judul agenda kegiatan wajib diisi.',
            'location.required' => 'Lokasi kegiatan wajib diisi.',
            'start_date.required' => 'Waktu dan tanggal kegiatan wajib diisi.',
            'banner_file.image' => 'Banner harus berupa berkas gambar.',
        ]);

        if ($validated['title'] !== $event->title) {
            $validated['slug'] = Str::slug($validated['title']) . '-' . Str::random(5);
        }

        if ($request->hasFile('banner_file')) {
            if ($event->banner) {
                $this->fileStorageService->deleteFile($event->banner);
            }
            $validated['banner'] = $this->fileStorageService->uploadImage($request->file('banner_file'), 'events');
            unset($validated['banner_file']);
        }

        $event->update($validated);

        return redirect()->route('admin.events.index')
            ->with('success', 'Agenda sekolah berhasil diperbarui.');
    }

    /**
     * Destroy event record.
     */
    public function destroy(Event $event): RedirectResponse
    {
        if ($event->banner) {
            $this->fileStorageService->deleteFile($event->banner);
        }

        $event->delete();

        return redirect()->route('admin.events.index')->with('success', 'Agenda berhasil dihapus.');
    }
}
