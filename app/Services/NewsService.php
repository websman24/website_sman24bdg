<?php

namespace App\Services;

use App\Models\News;
use App\Models\NewsCategory;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Str;

class NewsService
{
    /**
     * Get paginated news with category and author.
     */
    public function getPaginatedNews(int $perPage = 10): LengthAwarePaginator
    {
        return News::with(['category', 'author'])
            ->latest('published_at')
            ->paginate($perPage);
    }

    public function __construct(
        protected FileStorageService $fileStorageService
    ) {}

    /**
     * Create news article.
     */
    public function createNews(array $data, int $authorId): News
    {
        $data['author_id'] = $authorId;
        $data['slug'] = Str::slug($data['title']) . '-' . Str::random(5);
        $data['published_at'] = $data['published_at'] ?? now();

        if (isset($data['thumbnail_file']) && $data['thumbnail_file'] instanceof \Illuminate\Http\UploadedFile) {
            $data['thumbnail'] = $this->fileStorageService->uploadImage($data['thumbnail_file'], 'news');
            unset($data['thumbnail_file']);
        }

        return News::create($data);
    }

    /**
     * Update news article.
     */
    public function updateNews(News $news, array $data): bool
    {
        if (isset($data['title']) && $data['title'] !== $news->title) {
            $data['slug'] = Str::slug($data['title']) . '-' . Str::random(5);
        }

        return $news->update($data);
    }

    /**
     * Delete news article.
     */
    public function deleteNews(News $news): bool
    {
        if ($news->thumbnail) {
            $this->fileStorageService->deleteFile($news->thumbnail);
        }

        return $news->delete();
    }
}
