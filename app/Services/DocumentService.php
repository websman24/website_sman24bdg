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
     * Get paginated documents.
     */
    public function getPaginatedDocuments(int $perPage = 15): LengthAwarePaginator
    {
        return Document::with('author')
            ->latest()
            ->paginate($perPage);
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
