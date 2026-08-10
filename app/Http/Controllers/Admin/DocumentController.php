<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Document;
use App\Services\DocumentService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DocumentController extends Controller
{
    public function __construct(
        protected DocumentService $documentService
    ) {}

    /**
     * Display listing of documents.
     */
    public function index(): View
    {
        $documents = $this->documentService->getPaginatedDocuments(15);
        return view('admin.documents.index', compact('documents'));
    }

    /**
     * Show form to create document.
     */
    public function create(): View
    {
        return view('admin.documents.create');
    }

    /**
     * Store document record.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'category' => ['required', 'string', 'max:100'],
            'description' => ['nullable', 'string'],
        ], [
            'title.required' => 'Judul dokumen wajib diisi.',
            'category.required' => 'Kategori dokumen wajib dipilih.',
        ]);

        $validated['file_path'] = 'documents/sample.pdf';
        $validated['file_size'] = 1024000;
        $validated['file_type'] = 'pdf';

        $this->documentService->createDocument($validated, auth()->id());

        return redirect()->route('admin.documents.index')
            ->with('success', 'Dokumen publik / SPMB berhasil ditambahkan.');
    }

    /**
     * Destroy document record.
     */
    public function destroy(Document $document): RedirectResponse
    {
        $this->documentService->deleteDocument($document);

        return redirect()->route('admin.documents.index')
            ->with('success', 'Dokumen berhasil dihapus.');
    }
}
