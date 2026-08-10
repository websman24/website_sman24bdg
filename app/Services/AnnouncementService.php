<?php

namespace App\Services;

use App\Models\Announcement;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Str;

class AnnouncementService
{
    /**
     * Get paginated announcements.
     */
    public function getPaginatedAnnouncements(int $perPage = 10): LengthAwarePaginator
    {
        return Announcement::with('author')
            ->orderBy('is_pinned', 'desc')
            ->latest('published_at')
            ->paginate($perPage);
    }

    /**
     * Create announcement.
     */
    public function createAnnouncement(array $data, int $authorId): Announcement
    {
        $data['author_id'] = $authorId;
        $data['slug'] = Str::slug($data['title']) . '-' . Str::random(5);
        $data['published_at'] = $data['published_at'] ?? now();

        return Announcement::create($data);
    }

    /**
     * Delete announcement.
     */
    public function deleteAnnouncement(Announcement $announcement): bool
    {
        return $announcement->delete();
    }
}
