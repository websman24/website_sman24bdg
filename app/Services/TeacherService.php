<?php

namespace App\Services;

use App\Models\Teacher;
use Illuminate\Pagination\LengthAwarePaginator;

class TeacherService
{
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
        return Teacher::create($data);
    }

    /**
     * Delete teacher record.
     */
    public function deleteTeacher(Teacher $teacher): bool
    {
        return $teacher->delete();
    }
}
