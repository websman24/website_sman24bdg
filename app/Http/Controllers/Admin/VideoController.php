<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Video;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class VideoController extends Controller
{
    public function index(): View
    {
        $videos = Video::latest()->paginate(10);
        return view('admin.videos.index', compact('videos'));
    }

    public function create(): View
    {
        return view('admin.videos.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'youtube_url' => ['required', 'url', 'max:255'],
            'description' => ['nullable', 'string'],
        ]);

        // Extract YouTube ID
        preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $validated['youtube_url'], $match);
        $validated['youtube_id'] = $match[1] ?? 'dQw4w9WgXcQ';

        Video::create($validated);

        return redirect()->route('admin.videos.index')
            ->with('success', 'Video YouTube berhasil ditambahkan.');
    }

    public function destroy(Video $video): RedirectResponse
    {
        $video->delete();
        return redirect()->route('admin.videos.index')->with('success', 'Video berhasil dihapus.');
    }
}
