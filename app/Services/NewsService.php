<?php

namespace App\Services;

use App\Models\News;
use Illuminate\Http\UploadedFile;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Str;

class NewsService
{
    /**
     * Get paginated news with category and author, supporting search and filters.
     */
    public function getPaginatedNews(int $perPage = 10, ?string $search = null, ?string $status = null, ?int $categoryId = null): LengthAwarePaginator
    {
        $query = News::with(['category', 'author']);

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('excerpt', 'like', "%{$search}%")
                    ->orWhere('content', 'like', "%{$search}%");
            });
        }

        if ($status) {
            $query->where('status', $status);
        }

        if ($categoryId) {
            $query->where('category_id', $categoryId);
        }

        return $query->latest('published_at')
            ->latest('created_at')
            ->paginate($perPage)
            ->withQueryString();
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
        $data['slug'] = Str::slug($data['title']).'-'.Str::random(5);
        $data['published_at'] = $data['published_at'] ?? now();
        $data['content'] = clean($data['content']);

        if (isset($data['thumbnail_file']) && $data['thumbnail_file'] instanceof UploadedFile) {
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
            $data['slug'] = Str::slug($data['title']).'-'.Str::random(5);
        }

        if (isset($data['content'])) {
            $data['content'] = clean($data['content']);
        }

        if (isset($data['thumbnail_file']) && $data['thumbnail_file'] instanceof UploadedFile) {
            if ($news->thumbnail) {
                $this->fileStorageService->deleteFile($news->thumbnail);
            }
            $data['thumbnail'] = $this->fileStorageService->uploadImage($data['thumbnail_file'], 'news');
            unset($data['thumbnail_file']);
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
