<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DownloadController extends Controller
{
    /**
     * Display Downloads Page with search and category filter.
     */
    public function index(Request $request): View
    {
        $query = Document::with('author');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        $documents = $query->latest()->paginate(12)->withQueryString();
        $categories = Document::select('category')->distinct()->pluck('category');

        return view('public.download.index', compact('documents', 'categories'));
    }

    /**
     * Download public document file and increment download count.
     */
    public function download(Document $document)
    {
        $document->increment('download_count');

        $fullPath = public_path($document->file_path);

        if (file_exists($fullPath) && is_file($fullPath)) {
            return response()->download($fullPath, $document->title . '.' . pathinfo($fullPath, PATHINFO_EXTENSION));
        }

        return back()->with('success', 'Permintaan unduh dicatat. Berkas: ' . $document->title);
    }
}
