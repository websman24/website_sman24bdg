<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\OsisMember;
use App\Services\OsisService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class OsisController extends Controller
{
    public function __construct(
        protected OsisService $osisService
    ) {}

    /**
     * Display OSIS management hub (Profile & Members Tabs).
     */
    public function index(Request $request): View
    {
        $profile = $this->osisService->getProfile();

        $activeTab = $request->query('tab', 'profile');
        $search = $request->query('search');
        $department = $request->query('department');
        $status = $request->query('status');

        $members = $this->osisService->getPaginatedMembers(15, $search, $department, $status);
        $departments = OsisMember::DEPARTMENTS;

        $stats = [
            'total_members' => OsisMember::count(),
            'total_bph' => OsisMember::where('department', 'bph')->count(),
            'total_sekbid' => OsisMember::where('department', 'like', 'sekbid_%')->count(),
            'total_mpk' => OsisMember::where('department', 'mpk')->count(),
        ];

        return view('admin.osis.index', compact(
            'profile',
            'members',
            'departments',
            'activeTab',
            'search',
            'department',
            'status',
            'stats'
        ));
    }

    /**
     * Update OSIS profile (Cabinet, Vision, Mission, Socials, Welcome).
     */
    public function updateProfile(Request $request): RedirectResponse
    {
        $profile = $this->osisService->getProfile();

        $validated = $request->validate([
            'cabinet_name' => ['required', 'string', 'max:255'],
            'period' => ['required', 'string', 'max:50'],
            'tagline' => ['nullable', 'string', 'max:255'],
            'vision' => ['nullable', 'string'],
            'mission' => ['nullable', 'string'],
            'leader_name' => ['nullable', 'string', 'max:255'],
            'leader_welcome' => ['nullable', 'string'],
            'instagram_url' => ['nullable', 'string', 'max:255'],
            'tiktok_url' => ['nullable', 'string', 'max:255'],
            'youtube_url' => ['nullable', 'string', 'max:255'],
            'leader_photo' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'cabinet_photo' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
            'cabinet_logo' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ], [
            'cabinet_name.required' => 'Nama kabinet OSIS wajib diisi.',
            'period.required' => 'Periode kepengurusan wajib diisi.',
            'leader_photo.image' => 'Foto ketua harus berupa berkas gambar.',
            'cabinet_photo.image' => 'Foto kabinet harus berupa berkas gambar.',
        ]);

        $files = [];
        if ($request->hasFile('leader_photo')) {
            $files['leader_photo'] = $request->file('leader_photo');
        }
        if ($request->hasFile('cabinet_photo')) {
            $files['cabinet_photo'] = $request->file('cabinet_photo');
        }
        if ($request->hasFile('cabinet_logo')) {
            $files['cabinet_logo'] = $request->file('cabinet_logo');
        }

        $this->osisService->updateProfile($profile, $validated, $files);

        return redirect()->route('admin.osis.index', ['tab' => 'profile'])
            ->with('success', 'Profil & Kabinet OSIS berhasil diperbarui.');
    }

    /**
     * Show form to create a new OSIS member.
     */
    public function createMember(): View
    {
        $departments = OsisMember::DEPARTMENTS;

        return view('admin.osis.members.create', compact('departments'));
    }

    /**
     * Store a newly created OSIS member.
     */
    public function storeMember(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'position' => ['required', 'string', 'max:255'],
            'department' => ['required', 'string', 'in:'.implode(',', array_keys(OsisMember::DEPARTMENTS))],
            'class_grade' => ['nullable', 'string', 'max:50'],
            'instagram' => ['nullable', 'string', 'max:255'],
            'motto' => ['nullable', 'string', 'max:500'],
            'order_position' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
            'photo_file' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ], [
            'name.required' => 'Nama pengurus wajib diisi.',
            'position.required' => 'Jabatan pengurus wajib diisi.',
            'department.required' => 'Divisi/Sekbid wajib dipilih.',
            'photo_file.image' => 'Foto harus berupa berkas gambar.',
        ]);

        $validated['is_active'] = $request->has('is_active') ? $request->boolean('is_active') : true;
        $validated['order_position'] = $validated['order_position'] ?? 0;

        $photoFile = $request->hasFile('photo_file') ? $request->file('photo_file') : null;

        $this->osisService->createMember($validated, $photoFile);

        return redirect()->route('admin.osis.index', ['tab' => 'members'])
            ->with('success', 'Pengurus OSIS baru berhasil ditambahkan.');
    }

    /**
     * Show form to edit an OSIS member.
     */
    public function editMember(OsisMember $member): View
    {
        $departments = OsisMember::DEPARTMENTS;

        return view('admin.osis.members.edit', compact('member', 'departments'));
    }

    /**
     * Update the specified OSIS member.
     */
    public function updateMember(Request $request, OsisMember $member): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'position' => ['required', 'string', 'max:255'],
            'department' => ['required', 'string', 'in:'.implode(',', array_keys(OsisMember::DEPARTMENTS))],
            'class_grade' => ['nullable', 'string', 'max:50'],
            'instagram' => ['nullable', 'string', 'max:255'],
            'motto' => ['nullable', 'string', 'max:500'],
            'order_position' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
            'photo_file' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ], [
            'name.required' => 'Nama pengurus wajib diisi.',
            'position.required' => 'Jabatan pengurus wajib diisi.',
            'department.required' => 'Divisi/Sekbid wajib dipilih.',
            'photo_file.image' => 'Foto harus berupa berkas gambar.',
        ]);

        $validated['is_active'] = $request->has('is_active');
        $validated['order_position'] = $validated['order_position'] ?? 0;

        $photoFile = $request->hasFile('photo_file') ? $request->file('photo_file') : null;

        $this->osisService->updateMember($member, $validated, $photoFile);

        return redirect()->route('admin.osis.index', ['tab' => 'members'])
            ->with('success', 'Data pengurus OSIS berhasil diperbarui.');
    }

    /**
     * Remove the specified OSIS member.
     */
    public function destroyMember(OsisMember $member): RedirectResponse
    {
        $this->osisService->deleteMember($member);

        return redirect()->route('admin.osis.index', ['tab' => 'members'])
            ->with('success', 'Data pengurus OSIS berhasil dihapus.');
    }

    /**
     * Bulk delete selected OSIS members.
     */
    public function bulkDeleteMembers(Request $request): RedirectResponse
    {
        $request->validate([
            'ids' => ['required', 'array', 'min:1'],
            'ids.*' => ['integer', 'min:1'],
        ]);

        $ids = $request->input('ids', []);

        if (empty($ids)) {
            return redirect()->route('admin.osis.index', ['tab' => 'members'])
                ->with('error', 'Tidak ada data pengurus yang dipilih.');
        }

        $members = OsisMember::whereIn('id', $ids)->get();
        foreach ($members as $member) {
            $this->osisService->deleteMember($member);
        }

        return redirect()->route('admin.osis.index', ['tab' => 'members'])
            ->with('success', count($members).' data pengurus OSIS berhasil dihapus secara massal.');
    }
}
