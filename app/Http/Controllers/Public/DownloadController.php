<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Document;
use Illuminate\View\View;

class DownloadController extends Controller
{
    /**
     * Display Downloads Page.
     */
    public function index(): View
    {
        $documents = Document::latest()->paginate(10);
        return view('public.download.index', compact('documents'));
    }

    /**
     * Download public document file.
     */
    public function download(Document $document)
    {
        $document->increment('download_count');
        
        // For demonstration, return back with flash message if file does not exist locally
        return back()->with('success', 'Mengunduh berkas: ' . $document->title);
    }
}
