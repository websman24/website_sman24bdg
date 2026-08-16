<?php

namespace App\Services;

use App\Models\Gallery;
use App\Models\GalleryItem;
use Illuminate\Http\UploadedFile;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Str;

class GalleryService
{
    public function __construct(
        protected FileStorageService $fileStorageService
    ) {}

    /**
     * Get paginated galleries with search filter.
     */
    public function getPaginatedGalleries(int $perPage = 10, ?string $search = null): LengthAwarePaginator
    {
        $query = Gallery::withCount('items')->with('author');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        return $query->latest('published_at')->latest('created_at')->paginate($perPage)->withQueryString();
    }

    /**
     * Create gallery album.
     */
    public function createGallery(array $data, int $authorId): Gallery
    {
        $data['author_id'] = $authorId;
        $data['slug'] = Str::slug($data['title']).'-'.Str::random(5);
        $data['published_at'] = $data['published_at'] ?? now();

        if (isset($data['cover_image_file']) && $data['cover_image_file'] instanceof UploadedFile) {
            $data['cover_image'] = $this->fileStorageService->uploadImage($data['cover_image_file'], 'galleries/covers');
            unset($data['cover_image_file']);
        }

        return Gallery::create($data);
    }

    /**
     * Update gallery album.
     */
    public function updateGallery(Gallery $gallery, array $data): bool
    {
        if (isset($data['title']) && $data['title'] !== $gallery->title) {
            $data['slug'] = Str::slug($data['title']).'-'.Str::random(5);
        }

        if (isset($data['cover_image_file']) && $data['cover_image_file'] instanceof UploadedFile) {
            if ($gallery->cover_image) {
                $this->fileStorageService->deleteFile($gallery->cover_image);
            }
            $data['cover_image'] = $this->fileStorageService->uploadImage($data['cover_image_file'], 'galleries/covers');
            unset($data['cover_image_file']);
        }

        return $gallery->update($data);
    }

    /**
     * Add photo item to gallery.
     */
    public function addPhotoItem(Gallery $gallery, UploadedFile $photo, ?string $caption = null): GalleryItem
    {
        $imagePath = $this->fileStorageService->uploadImage($photo, "galleries/{$gallery->id}");

        /** @var GalleryItem $item */
        $item = $gallery->items()->create([
            'image_path' => $imagePath,
            'caption' => $caption,
            'order_position' => $gallery->items()->count() + 1,
        ]);

        // Auto-set cover image if none exists
        if (! $gallery->cover_image) {
            $gallery->update(['cover_image' => $imagePath]);
        }

        return $item;
    }

    /**
     * Delete photo item from gallery.
     */
    public function deletePhotoItem(GalleryItem $item): bool
    {
        if ($item->image_path) {
            $this->fileStorageService->deleteFile($item->image_path);
        }

        return $item->delete();
    }

    /**
     * Delete entire gallery album with all photo items.
     */
    public function deleteGallery(Gallery $gallery): bool
    {
        /** @var GalleryItem $item */
        foreach ($gallery->items as $item) {
            $this->deletePhotoItem($item);
        }

        if ($gallery->cover_image) {
            $this->fileStorageService->deleteFile($gallery->cover_image);
        }

        return $gallery->delete();
    }
}
