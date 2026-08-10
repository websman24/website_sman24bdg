<?php

namespace App\Services;

use App\Models\Document;
use Illuminate\Pagination\LengthAwarePaginator;

class DocumentService
{
    public function __construct(
        protected FileStorageService $fileStorageService
    ) {}

    /**
     * Get paginated documents with search and category filter.
     */
    public function getPaginatedDocuments(int $perPage = 15, ?string $search = null, ?string $category = null): LengthAwarePaginator
    {
        $query = Document::with('author');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        if ($category) {
            $query->where('category', $category);
        }

        return $query->latest()->paginate($perPage)->withQueryString();
    }

    /**
     * Create document record.
     */
    public function createDocument(array $data, int $authorId): Document
    {
        $data['author_id'] = $authorId;

        if (isset($data['document_file']) && $data['document_file'] instanceof \Illuminate\Http\UploadedFile) {
            $uploadInfo = $this->fileStorageService->uploadDocument($data['document_file'], 'documents');
            $data['file_path'] = $uploadInfo['file_path'];
            $data['file_size'] = $uploadInfo['file_size'];
            $data['file_type'] = $uploadInfo['file_type'];
            unset($data['document_file']);
        } else {
            $data['file_path'] = $data['file_path'] ?? 'documents/sample.pdf';
            $data['file_size'] = $data['file_size'] ?? 1024000;
            $data['file_type'] = $data['file_type'] ?? 'pdf';
        }

        return Document::create($data);
    }

    /**
     * Update document record.
     */
    public function updateDocument(Document $document, array $data): bool
    {
        if (isset($data['document_file']) && $data['document_file'] instanceof \Illuminate\Http\UploadedFile) {
            if ($document->file_path) {
                $this->fileStorageService->deleteFile($document->file_path);
            }
            $uploadInfo = $this->fileStorageService->uploadDocument($data['document_file'], 'documents');
            $data['file_path'] = $uploadInfo['file_path'];
            $data['file_size'] = $uploadInfo['file_size'];
            $data['file_type'] = $uploadInfo['file_type'];
            unset($data['document_file']);
        }

        return $document->update($data);
    }

    /**
     * Delete document record.
     */
    public function deleteDocument(Document $document): bool
    {
        if ($document->file_path) {
            $this->fileStorageService->deleteFile($document->file_path);
        }

        return $document->delete();
    }
}
