<?php

namespace App\Services;

use App\Models\Document;
use Illuminate\Pagination\LengthAwarePaginator;

class DocumentService
{
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
        return Document::create($data);
    }

    /**
     * Delete document record.
     */
    public function deleteDocument(Document $document): bool
    {
        return $document->delete();
    }
}
