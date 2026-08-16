<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Video;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class VideoController extends Controller
{
    /**
     * Display listing of YouTube videos with search.
     */
    public function index(Request $request): View
    {
        $search = $request->query('search');

        $query = Video::query();

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        $videos = $query->latest()->paginate(10)->withQueryString();

        return view('admin.videos.index', compact('videos', 'search'));
    }

    /**
     * Show form to create video.
     */
    public function create(): View
    {
        return view('admin.videos.create');
    }

    /**
     * Store video record.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'youtube_url' => ['required', 'url', 'max:255'],
            'description' => ['nullable', 'string'],
            'is_featured' => ['nullable', 'boolean'],
        ], [
            'title.required' => 'Judul video wajib diisi.',
            'youtube_url.required' => 'Tautan YouTube wajib diisi.',
            'youtube_url.url' => 'Format URL YouTube tidak valid.',
        ]);

        $validated['youtube_id'] = $this->extractYoutubeId($validated['youtube_url']);
        $validated['is_featured'] = $request->boolean('is_featured');

        Video::create($validated);

        return redirect()->route('admin.videos.index')
            ->with('success', 'Video dokumentasi YouTube berhasil ditambahkan.');
    }

    /**
     * Show form to edit video.
     */
    public function edit(Video $video): View
    {
        return view('admin.videos.edit', compact('video'));
    }

    /**
     * Update video record.
     */
    public function update(Request $request, Video $video): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'youtube_url' => ['required', 'url', 'max:255'],
            'description' => ['nullable', 'string'],
            'is_featured' => ['nullable', 'boolean'],
        ], [
            'title.required' => 'Judul video wajib diisi.',
            'youtube_url.required' => 'Tautan YouTube wajib diisi.',
            'youtube_url.url' => 'Format URL YouTube tidak valid.',
        ]);

        $validated['youtube_id'] = $this->extractYoutubeId($validated['youtube_url']);
        $validated['is_featured'] = $request->boolean('is_featured');

        $video->update($validated);

        return redirect()->route('admin.videos.index')
            ->with('success', 'Informasi video YouTube berhasil diperbarui.');
    }

    /**
     * Destroy video record.
     */
    public function destroy(Video $video): RedirectResponse
    {
        $video->delete();

        return redirect()->route('admin.videos.index')->with('success', 'Video berhasil dihapus.');
    }

    /**
     * Helper to extract YouTube video ID from various YouTube URL formats.
     */
    protected function extractYoutubeId(string $url): string
    {
        preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $url, $match);

        return $match[1] ?? 'dQw4w9WgXcQ';
    }
}
