<?php

namespace App\Services;

use App\Models\Staff;
use Illuminate\Http\UploadedFile;
use Illuminate\Pagination\LengthAwarePaginator;

class StaffService
{
    public function __construct(
        protected FileStorageService $fileStorageService
    ) {}

    /**
     * Get paginated staff records with search & filter.
     */
    public function getPaginatedStaff(int $perPage = 15, ?string $search = null, ?string $status = null, ?string $gender = null): LengthAwarePaginator
    {
        $query = Staff::query();

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('nip', 'like', "%{$search}%")
                    ->orWhere('position', 'like', "%{$search}%");
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
     * Create staff record.
     */
    public function createStaff(array $data): Staff
    {
        if (isset($data['photo_file']) && $data['photo_file'] instanceof UploadedFile) {
            $data['photo'] = $this->fileStorageService->uploadImage($data['photo_file'], 'staff');
            unset($data['photo_file']);
        }

        return Staff::create($data);
    }

    /**
     * Update staff record.
     */
    public function updateStaff(Staff $staff, array $data): bool
    {
        if (isset($data['photo_file']) && $data['photo_file'] instanceof UploadedFile) {
            if ($staff->photo) {
                $this->fileStorageService->deleteFile($staff->photo);
            }
            $data['photo'] = $this->fileStorageService->uploadImage($data['photo_file'], 'staff');
            unset($data['photo_file']);
        }

        return $staff->update($data);
    }

    /**
     * Delete staff record.
     */
    public function deleteStaff(Staff $staff): bool
    {
        if ($staff->photo) {
            $this->fileStorageService->deleteFile($staff->photo);
        }

        return $staff->delete();
    }
}
