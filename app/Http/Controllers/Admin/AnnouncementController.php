<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use App\Services\AnnouncementService;
use App\Traits\AuthorizesOwnership;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AnnouncementController extends Controller
{
    use AuthorizesOwnership;
    public function __construct(
        protected AnnouncementService $announcementService
    ) {}

    /**
     * Display a listing of announcements with search and filter.
     */
    public function index(Request $request): View
    {
        $search = $request->query('search');
        $status = $request->query('status');

        $announcements = $this->announcementService->getPaginatedAnnouncements(10, $search, $status);

        return view('admin.announcements.index', compact('announcements', 'search', 'status'));
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
            'attachment_file_input' => ['nullable', 'file', 'mimes:pdf,doc,docx,jpg,png,webp', 'max:5120'],
        ], [
            'title.required' => 'Judul pengumuman wajib diisi.',
            'content.required' => 'Konten pengumuman wajib diisi.',
            'attachment_file_input.mimes' => 'Berkas lampiran harus berupa PDF, Word, atau gambar.',
        ]);

        $validated['is_pinned'] = $request->boolean('is_pinned');
        $this->announcementService->createAnnouncement($validated, auth()->id());

        return redirect()->route('admin.announcements.index')
            ->with('success', 'Pengumuman baru berhasil ditambahkan.');
    }

    /**
     * Show form to edit announcement.
     */
    public function edit(Announcement $announcement): View
    {
        $this->authorizeOwnership($announcement);

        return view('admin.announcements.edit', compact('announcement'));
    }

    /**
     * Update announcement.
     */
    public function update(Request $request, Announcement $announcement): RedirectResponse
    {
        $this->authorizeOwnership($announcement);

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'content' => ['required', 'string'],
            'is_pinned' => ['nullable', 'boolean'],
            'status' => ['required', 'in:draft,published'],
            'attachment_file_input' => ['nullable', 'file', 'mimes:pdf,doc,docx,jpg,png,webp', 'max:5120'],
        ], [
            'title.required' => 'Judul pengumuman wajib diisi.',
            'content.required' => 'Konten pengumuman wajib diisi.',
            'attachment_file_input.mimes' => 'Berkas lampiran harus berupa PDF, Word, atau gambar.',
        ]);

        $validated['is_pinned'] = $request->boolean('is_pinned');
        $this->announcementService->updateAnnouncement($announcement, $validated);

        return redirect()->route('admin.announcements.index')
            ->with('success', 'Pengumuman berhasil diperbarui.');
    }

    /**
     * Destroy announcement.
     */
    public function destroy(Announcement $announcement): RedirectResponse
    {
        $this->authorizeOwnership($announcement);

        $this->announcementService->deleteAnnouncement($announcement);

        return redirect()->route('admin.announcements.index')
            ->with('success', 'Pengumuman berhasil dihapus.');
    }

    /**
     * Bulk delete selected announcements.
     *
     * Security: validates ids as array of integers before processing.
     */
    public function bulkDelete(Request $request): RedirectResponse
    {
        $request->validate([
            'ids' => ['required', 'array', 'min:1'],
            'ids.*' => ['integer', 'min:1'],
        ]);

        $ids = $request->input('ids', []);

        if (empty($ids)) {
            return redirect()->route('admin.announcements.index')->with('error', 'Tidak ada pengumuman yang dipilih.');
        }

        $items = Announcement::whereIn('id', $ids)->get();

        // Check ownership before deleting
        foreach ($items as $item) {
            $this->authorizeOwnership($item);
        }

        foreach ($items as $item) {
            $this->announcementService->deleteAnnouncement($item);
        }

        return redirect()->route('admin.announcements.index')
            ->with('success', count($items).' pengumuman berhasil dihapus secara massal.');
    }
}
