<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use App\Services\AnnouncementService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AnnouncementController extends Controller
{
    public function __construct(
        protected AnnouncementService $announcementService
    ) {}

    /**
     * Display a listing of announcements.
     */
    public function index(): View
    {
        $announcements = $this->announcementService->getPaginatedAnnouncements(10);
        return view('admin.announcements.index', compact('announcements'));
    }

    /**
     * Show form to create announcement.
     */
    public function create(): View
    {
        return view('admin.announcements.create');
    }

    /**
     * Store announcement.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'content' => ['required', 'string'],
            'is_pinned' => ['nullable', 'boolean'],
            'status' => ['required', 'in:draft,published'],
        ], [
            'title.required' => 'Judul pengumuman wajib diisi.',
            'content.required' => 'Konten pengumuman wajib diisi.',
        ]);

        $validated['is_pinned'] = $request->boolean('is_pinned');
        $this->announcementService->createAnnouncement($validated, auth()->id());

        return redirect()->route('admin.announcements.index')
            ->with('success', 'Pengumuman baru berhasil ditambahkan.');
    }

    /**
     * Destroy announcement.
     */
    public function destroy(Announcement $announcement): RedirectResponse
    {
        $this->announcementService->deleteAnnouncement($announcement);

        return redirect()->route('admin.announcements.index')
            ->with('success', 'Pengumuman berhasil dihapus.');
    }
}
