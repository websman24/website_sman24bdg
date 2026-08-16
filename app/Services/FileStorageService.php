<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class FileStorageService
{
    /**
     * Dangerous file extensions that must never be stored, even if disguised.
     *
     * @var list<string>
     */
    private const DANGEROUS_EXTENSIONS = [
        'php', 'php3', 'php4', 'php5', 'php7', 'phtml', 'phar',
        'asp', 'aspx', 'asa', 'asax',
        'cgi', 'pl', 'py', 'rb', 'sh', 'bash',
        'exe', 'com', 'bat', 'cmd', 'vbs', 'ps1',
        'htaccess', 'htpasswd',
        'jsp', 'jspx', 'cfm',
        'svgz', // Compressed SVG — can contain scripts
    ];

    /**
     * Mapping of allowed MIME types to safe file extensions.
     * Extension is derived from server-detected MIME, not client filename.
     *
     * @var array<string, string>
     */
    private const MIME_TO_EXTENSION = [
        'image/jpeg' => 'jpg',
        'image/jpg' => 'jpg',
        'image/png' => 'png',
        'image/gif' => 'gif',
        'image/webp' => 'webp',
        'application/pdf' => 'pdf',
        'application/msword' => 'doc',
        'application/vnd.openxmlformats-officedocument.wordprocessingml.document' => 'docx',
        'application/vnd.ms-excel' => 'xls',
        'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' => 'xlsx',
        'text/csv' => 'csv',
        'text/plain' => 'txt',
        'application/zip' => 'zip',
        'application/x-zip-compressed' => 'zip',
    ];

    /**
     * Upload an image file to public storage disk.
     *
     * Extension is determined by server MIME detection, not by the client filename.
     */
    public function uploadImage(UploadedFile $file, string $directory = 'images'): string
    {
        $this->ensureSafeExtension($file);

        $extension = $this->getExtensionFromMime($file);
        $filename = Str::uuid().'.'.$extension;
        $path = $file->storeAs("uploads/{$directory}", $filename, 'public');

        return "storage/{$path}";
    }

    /**
     * Upload any generic file to public storage disk.
     *
     * Extension is determined by server MIME detection, not by the client filename.
     */
    public function uploadFile(UploadedFile $file, string $directory = 'files'): string
    {
        $this->ensureSafeExtension($file);

        $extension = $this->getExtensionFromMime($file);
        $filename = Str::uuid().'.'.$extension;
        $path = $file->storeAs("uploads/{$directory}", $filename, 'public');

        return "storage/{$path}";
    }

    /**
     * Upload a document to the PRIVATE (non-public) storage disk.
     *
     * Documents are served through the DownloadController, not directly via URL.
     * This prevents direct access to sensitive documents via guessable URLs.
     */
    public function uploadDocument(UploadedFile $file, string $directory = 'documents'): array
    {
        $this->ensureSafeExtension($file);

        $extension = $this->getExtensionFromMime($file);
        $filename = Str::uuid().'.'.$extension;

        // Store in LOCAL (private) disk — NOT accessible via public URL
        $path = $file->storeAs("uploads/{$directory}", $filename, 'local');

        return [
            'file_path' => $path,    // Relative path in local disk (no 'storage/' prefix)
            'file_size' => $file->getSize(),
            'file_type' => $extension,
        ];
    }

    /**
     * Delete a stored file from the appropriate storage disk.
     *
     * Automatically detects whether the file is on the public or local disk
     * based on the path prefix.
     */
    public function deleteFile(?string $filePath): void
    {
        if (! $filePath) {
            return;
        }

        // Public disk: path starts with "storage/"
        if (str_starts_with($filePath, 'storage/')) {
            $relativeStoragePath = str_replace('storage/', '', $filePath);
            if (Storage::disk('public')->exists($relativeStoragePath)) {
                Storage::disk('public')->delete($relativeStoragePath);
            }

            return;
        }

        // Local (private) disk
        if (Storage::disk('local')->exists($filePath)) {
            Storage::disk('local')->delete($filePath);
        }
    }

    /**
     * Get the actual file extension based on server-detected MIME type.
     *
     * Falls back to client extension ONLY if the MIME is not in our known list,
     * but still checks against the dangerous extensions denylist.
     */
    private function getExtensionFromMime(UploadedFile $file): string
    {
        $mime = $file->getMimeType(); // Server-detected via finfo

        if ($mime && isset(self::MIME_TO_EXTENSION[$mime])) {
            return self::MIME_TO_EXTENSION[$mime];
        }

        // Fallback: use client extension but sanitize it
        $clientExtension = strtolower($file->getClientOriginalExtension());

        return $clientExtension ?: 'bin';
    }

    /**
     * Ensure the file does not have a dangerous extension.
     *
     * Checks both client-provided extension AND MIME-derived extension.
     *
     * @throws \InvalidArgumentException if a dangerous extension is detected
     */
    private function ensureSafeExtension(UploadedFile $file): void
    {
        $clientExtension = strtolower($file->getClientOriginalExtension());
        $mimeExtension = $this->getExtensionFromMime($file);

        if (in_array($clientExtension, self::DANGEROUS_EXTENSIONS, true)) {
            throw new \InvalidArgumentException(
                "File upload rejected: dangerous extension '.{$clientExtension}' is not allowed."
            );
        }

        if (in_array($mimeExtension, self::DANGEROUS_EXTENSIONS, true)) {
            throw new \InvalidArgumentException(
                "File upload rejected: detected file type '.{$mimeExtension}' is not allowed."
            );
        }
    }
}
