<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class FileStorageService
{
    /**
     * Upload an image file to public storage disk.
     */
    public function uploadImage(UploadedFile $file, string $directory = 'images'): string
    {
        $filename = Str::uuid() . '.' . $file->getClientOriginalExtension();
        $path = $file->storeAs("uploads/{$directory}", $filename, 'public');
        return "storage/{$path}";
    }

    /**
     * Upload a document file to public storage disk.
     */
    public function uploadDocument(UploadedFile $file, string $directory = 'documents'): array
    {
        $filename = Str::uuid() . '.' . $file->getClientOriginalExtension();
        $path = $file->storeAs("uploads/{$directory}", $filename, 'public');

        return [
            'file_path' => "storage/{$path}",
            'file_size' => $file->getSize(),
            'file_type' => $file->getClientOriginalExtension(),
        ];
    }

    /**
     * Delete a stored file from public storage disk if exists.
     */
    public function deleteFile(?string $filePath): void
    {
        if (!$filePath) {
            return;
        }

        $relativeStoragePath = str_replace('storage/', '', $filePath);

        if (Storage::disk('public')->exists($relativeStoragePath)) {
            Storage::disk('public')->delete($relativeStoragePath);
        }
    }
}
