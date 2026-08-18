<?php

namespace App\Services;

use App\Models\OsisMember;
use App\Models\OsisProfile;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\UploadedFile;

class OsisService
{
    public function __construct(
        protected FileStorageService $fileStorageService
    ) {}

    /**
     * Get the active OSIS profile.
     */
    public function getProfile(): OsisProfile
    {
        return OsisProfile::current();
    }

    /**
     * Update OSIS profile and handle file uploads.
     */
    public function updateProfile(OsisProfile $profile, array $data, array $files = []): OsisProfile
    {
        if (isset($files['leader_photo']) && $files['leader_photo'] instanceof UploadedFile) {
            if ($profile->leader_photo) {
                $this->fileStorageService->deleteFile($profile->leader_photo);
            }
            $data['leader_photo'] = $this->fileStorageService->uploadImage($files['leader_photo'], 'osis');
        }

        if (isset($files['cabinet_photo']) && $files['cabinet_photo'] instanceof UploadedFile) {
            if ($profile->cabinet_photo) {
                $this->fileStorageService->deleteFile($profile->cabinet_photo);
            }
            $data['cabinet_photo'] = $this->fileStorageService->uploadImage($files['cabinet_photo'], 'osis');
        }

        if (isset($files['cabinet_logo']) && $files['cabinet_logo'] instanceof UploadedFile) {
            if ($profile->cabinet_logo) {
                $this->fileStorageService->deleteFile($profile->cabinet_logo);
            }
            $data['cabinet_logo'] = $this->fileStorageService->uploadImage($files['cabinet_logo'], 'osis');
        }

        $profile->update($data);

        return $profile;
    }

    /**
     * Get paginated OSIS members with search & filters.
     */
    public function getPaginatedMembers(
        int $perPage = 15,
        ?string $search = null,
        ?string $department = null,
        ?string $status = null
    ): LengthAwarePaginator {
        $query = OsisMember::query();

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('position', 'like', "%{$search}%")
                    ->orWhere('class_grade', 'like', "%{$search}%");
            });
        }

        if ($department) {
            $query->where('department', $department);
        }

        if ($status !== null && $status !== '') {
            $isActive = in_array($status, ['1', 'active', 'true'], true);
            $query->where('is_active', $isActive);
        }

        return $query->orderBy('order_position', 'asc')
            ->orderBy('id', 'asc')
            ->paginate($perPage)
            ->withQueryString();
    }

    /**
     * Create new OSIS member.
     */
    public function createMember(array $data, ?UploadedFile $photoFile = null): OsisMember
    {
        unset($data['photo_file']);

        if ($photoFile) {
            $data['photo'] = $this->fileStorageService->uploadImage($photoFile, 'osis/members');
        }

        return OsisMember::create($data);
    }

    /**
     * Update OSIS member.
     */
    public function updateMember(OsisMember $member, array $data, ?UploadedFile $photoFile = null): OsisMember
    {
        unset($data['photo_file']);

        if ($photoFile) {
            if ($member->photo) {
                $this->fileStorageService->deleteFile($member->photo);
            }
            $data['photo'] = $this->fileStorageService->uploadImage($photoFile, 'osis/members');
        }

        $member->update($data);

        return $member;
    }

    /**
     * Delete OSIS member.
     */
    public function deleteMember(OsisMember $member): bool
    {
        if ($member->photo) {
            $this->fileStorageService->deleteFile($member->photo);
        }

        return $member->delete();
    }
}
