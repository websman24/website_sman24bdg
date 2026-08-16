<?php

namespace App\Services;

use App\Models\Announcement;
use Illuminate\Http\UploadedFile;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Str;

class AnnouncementService
{
    public function __construct(
        protected FileStorageService $fileStorageService
    ) {}

    /**
     * Get paginated announcements with search and status filter.
     */
    public function getPaginatedAnnouncements(int $perPage = 10, ?string $search = null, ?string $status = null): LengthAwarePaginator
    {
        $query = Announcement::with('author');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('content', 'like', "%{$search}%");
            });
        }

        if ($status) {
            $query->where('status', $status);
        }

        return $query->orderBy('is_pinned', 'desc')
            ->latest('published_at')
            ->latest('created_at')
            ->paginate($perPage)
            ->withQueryString();
    }

    /**
     * Create announcement.
     */
    public function createAnnouncement(array $data, int $authorId): Announcement
    {
        $data['author_id'] = $authorId;
        $data['slug'] = Str::slug($data['title']).'-'.Str::random(5);
        $data['published_at'] = $data['published_at'] ?? now();
        $data['content'] = clean($data['content']);

        if (isset($data['attachment_file_input']) && $data['attachment_file_input'] instanceof UploadedFile) {
            $data['attachment_file'] = $this->fileStorageService->uploadFile($data['attachment_file_input'], 'announcements');
            unset($data['attachment_file_input']);
        }

        return Announcement::create($data);
    }

    /**
     * Update announcement.
     */
    public function updateAnnouncement(Announcement $announcement, array $data): bool
    {
        if (isset($data['title']) && $data['title'] !== $announcement->title) {
            $data['slug'] = Str::slug($data['title']).'-'.Str::random(5);
        }

        if (isset($data['content'])) {
            $data['content'] = clean($data['content']);
        }

        if (isset($data['attachment_file_input']) && $data['attachment_file_input'] instanceof UploadedFile) {
            if ($announcement->attachment_file) {
                $this->fileStorageService->deleteFile($announcement->attachment_file);
            }
            $data['attachment_file'] = $this->fileStorageService->uploadFile($data['attachment_file_input'], 'announcements');
            unset($data['attachment_file_input']);
        }

        return $announcement->update($data);
    }

    /**
     * Delete announcement.
     */
    public function deleteAnnouncement(Announcement $announcement): bool
    {
        if ($announcement->attachment_file) {
            $this->fileStorageService->deleteFile($announcement->attachment_file);
        }

        return $announcement->delete();
    }
}
