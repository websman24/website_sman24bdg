<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Document;
use App\Services\DocumentService;
use App\Traits\AuthorizesOwnership;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DocumentController extends Controller
{
    use AuthorizesOwnership;
    public function __construct(
        protected DocumentService $documentService
    ) {}

    /**
     * Display listing of documents with search and category filter.
     */
    public function index(Request $request): View
    {
        $search = $request->query('search');
        $category = $request->query('category');

        $documents = $this->documentService->getPaginatedDocuments(15, $search, $category);
        $categories = Document::select('category')->distinct()->pluck('category');

        return view('admin.documents.index', compact('documents', 'categories', 'search', 'category'));
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
            'document_file' => ['nullable', 'file', 'mimes:pdf,doc,docx,xls,xlsx,zip', 'max:10240'],
        ], [
            'title.required' => 'Judul dokumen wajib diisi.',
            'category.required' => 'Kategori dokumen wajib dipilih.',
            'document_file.mimes' => 'Format file yang diperbolehkan: PDF, DOC, DOCX, XLS, XLSX, ZIP.',
        ]);

        $this->documentService->createDocument($validated, auth()->id());

        return redirect()->route('admin.documents.index')
            ->with('success', 'Dokumen publik berhasil ditambahkan ke pusat unduhan.');
    }

    /**
     * Show form to edit document.
     */
    public function edit(Document $document): View
    {
        $this->authorizeOwnership($document);

        return view('admin.documents.edit', compact('document'));
    }

    /**
     * Update document record.
     */
    public function update(Request $request, Document $document): RedirectResponse
    {
        $this->authorizeOwnership($document);

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'category' => ['required', 'string', 'max:100'],
            'description' => ['nullable', 'string'],
            'document_file' => ['nullable', 'file', 'mimes:pdf,doc,docx,xls,xlsx,zip', 'max:10240'],
        ], [
            'title.required' => 'Judul dokumen wajib diisi.',
            'category.required' => 'Kategori dokumen wajib dipilih.',
            'document_file.mimes' => 'Format file yang diperbolehkan: PDF, DOC, DOCX, XLS, XLSX, ZIP.',
        ]);

        $this->documentService->updateDocument($document, $validated);

        return redirect()->route('admin.documents.index')
            ->with('success', 'Informasi dokumen berhasil diperbarui.');
    }

    /**
     * Destroy document record.
     */
    public function destroy(Document $document): RedirectResponse
    {
        $this->authorizeOwnership($document);

        $this->documentService->deleteDocument($document);

        return redirect()->route('admin.documents.index')
            ->with('success', 'Dokumen berhasil dihapus.');
    }
}
