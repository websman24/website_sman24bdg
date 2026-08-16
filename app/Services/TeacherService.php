<?php

namespace App\Services;

use App\Models\Teacher;
use Illuminate\Http\UploadedFile;
use Illuminate\Pagination\LengthAwarePaginator;

class TeacherService
{
    public function __construct(
        protected FileStorageService $fileStorageService
    ) {}

    /**
     * Get paginated teachers with search & filter.
     */
    public function getPaginatedTeachers(int $perPage = 15, ?string $search = null, ?string $status = null, ?string $gender = null): LengthAwarePaginator
    {
        $query = Teacher::query();

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('nip', 'like', "%{$search}%")
                    ->orWhere('subject', 'like', "%{$search}%");
            });
        }

        if ($status !== null && $status !== '') {
            $query->where('is_active', $status === 'active' || $status === '1');
        }

        if ($gender) {
            $query->where('gender', $gender);
        }

        return $query->orderBy('order_position', 'asc')
            ->orderBy('name', 'asc')
            ->paginate($perPage)
            ->withQueryString();
    }

    /**
     * Create teacher record.
     */
    public function createTeacher(array $data): Teacher
    {
        if (isset($data['photo_file']) && $data['photo_file'] instanceof UploadedFile) {
            $data['photo'] = $this->fileStorageService->uploadImage($data['photo_file'], 'teachers');
            unset($data['photo_file']);
        }

        return Teacher::create($data);
    }

    /**
     * Update teacher record.
     */
    public function updateTeacher(Teacher $teacher, array $data): bool
    {
        if (isset($data['photo_file']) && $data['photo_file'] instanceof UploadedFile) {
            if ($teacher->photo) {
                $this->fileStorageService->deleteFile($teacher->photo);
            }
            $data['photo'] = $this->fileStorageService->uploadImage($data['photo_file'], 'teachers');
            unset($data['photo_file']);
        }

        return $teacher->update($data);
    }

    /**
     * Delete teacher record.
     */
    public function deleteTeacher(Teacher $teacher): bool
    {
        if ($teacher->photo) {
            $this->fileStorageService->deleteFile($teacher->photo);
        }

        return $teacher->delete();
    }
}
