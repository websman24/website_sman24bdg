<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class DownloadController extends Controller
{
    /**
     * Display Downloads Page with search and category filter.
     */
    public function index(Request $request): View
    {
        $query = Document::with('author');

        if ($request->filled('search')) {
            $search = $request->query('search'); // Use query() — safer than magic property
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        if ($request->filled('category')) {
            $query->where('category', $request->query('category'));
        }

        $documents = $query->latest()->paginate(12)->withQueryString();
        $categories = Document::select('category')->distinct()->pluck('category');

        return view('public.download.index', compact('documents', 'categories'));
    }

    /**
     * Serve a document file for download and increment download count.
     *
     * Security improvements over the previous implementation:
     * 1. No path traversal risk — file path comes from the database record,
     *    not directly from user input.
     * 2. Files are served from the private local disk via Storage::download(),
     *    so they cannot be accessed directly via a guessable URL.
     * 3. Path is validated to ensure it stays within the allowed uploads/documents prefix.
     * 4. Rate limiting is applied via the 'throttle:20,1' middleware on the route.
     */
    public function download(Document $document): StreamedResponse|\Illuminate\Http\RedirectResponse
    {
        $filePath = $document->file_path;

        // Guard: file_path must be set
        if (empty($filePath)) {
            return back()->with('error', 'Berkas tidak tersedia untuk dokumen ini.');
        }

        // Security: Normalize path and verify it stays within allowed directory prefix.
        // This prevents path traversal even if the database record were compromised.
        $normalizedPath = ltrim(str_replace(['..', '\\', "\0"], '', $filePath), '/');

        $allowedPrefixes = ['uploads/documents/', 'storage/uploads/documents/'];
        $isAllowed = false;

        foreach ($allowedPrefixes as $prefix) {
            if (str_starts_with($normalizedPath, $prefix)) {
                $isAllowed = true;
                break;
            }
        }

        if (! $isAllowed) {
            // Log suspicious access attempt for security monitoring
            \Illuminate\Support\Facades\Log::warning('Suspicious document download path detected', [
                'document_id' => $document->id,
                'file_path' => $filePath,
                'ip' => request()->ip(),
                'timestamp' => now()->toIso8601String(),
            ]);

            return back()->with('error', 'Berkas tidak dapat diakses.');
        }

        // Determine which disk to use based on path format
        // New uploads: local disk (private) — path like "uploads/documents/uuid.pdf"
        // Legacy uploads: public disk — path like "storage/uploads/documents/uuid.pdf"
        if (str_starts_with($normalizedPath, 'storage/')) {
            // Legacy public disk file
            $diskPath = str_replace('storage/', '', $normalizedPath);
            $disk = 'public';
        } else {
            // New private disk file
            $diskPath = $normalizedPath;
            $disk = 'local';
        }

        if (! Storage::disk($disk)->exists($diskPath)) {
            return back()->with('error', 'Berkas tidak ditemukan di server.');
        }

        // Increment download counter
        $document->increment('download_count');

        // Build a safe download filename: title + extension
        $extension = pathinfo($diskPath, PATHINFO_EXTENSION);
        $safeFilename = preg_replace('/[^a-zA-Z0-9\-_\. ]/', '', $document->title).".{$extension}";

        return Storage::disk($disk)->download($diskPath, $safeFilename);
    }
}
