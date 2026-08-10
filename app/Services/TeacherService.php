<?php

namespace App\Services;

use App\Models\Teacher;
use Illuminate\Pagination\LengthAwarePaginator;

class TeacherService
{
    public function __construct(
        protected FileStorageService $fileStorageService
    ) {}

    /**
     * Get paginated teachers.
     */
    public function getPaginatedTeachers(int $perPage = 15): LengthAwarePaginator
    {
        return Teacher::orderBy('order_position', 'asc')
            ->orderBy('name', 'asc')
            ->paginate($perPage);
    }

    /**
     * Create teacher record.
     */
    public function createTeacher(array $data): Teacher
    {
        if (isset($data['photo_file']) && $data['photo_file'] instanceof \Illuminate\Http\UploadedFile) {
            $data['photo'] = $this->fileStorageService->uploadImage($data['photo_file'], 'teachers');
            unset($data['photo_file']);
        }

        return Teacher::create($data);
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
