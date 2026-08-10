<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Staff;
use App\Services\StaffService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class StaffController extends Controller
{
    public function __construct(
        protected StaffService $staffService
    ) {}

    /**
     * Display listing of staff with search and filter.
     */
    public function index(Request $request): View
    {
        $search = $request->query('search');
        $status = $request->query('status');
        $gender = $request->query('gender');

        $staffMembers = $this->staffService->getPaginatedStaff(15, $search, $status, $gender);

        return view('admin.staff.index', compact('staffMembers', 'search', 'status', 'gender'));
    }

    /**
     * Show form to create staff record.
     */
    public function create(): View
    {
        return view('admin.staff.create');
    }

    /**
     * Store staff record.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'nip' => ['nullable', 'string', 'max:50', 'unique:staff,nip'],
            'position' => ['required', 'string', 'max:255'],
            'gender' => ['required', 'in:L,P'],
            'email' => ['nullable', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:50'],
            'order_position' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
            'photo_file' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ], [
            'name.required' => 'Nama tenaga kependidikan wajib diisi.',
            'position.required' => 'Jabatan wajib diisi.',
            'nip.unique' => 'NIP sudah terdaftar.',
            'photo_file.image' => 'Foto harus berupa berkas gambar.',
        ]);

        $validated['is_active'] = $request->has('is_active') ? $request->boolean('is_active') : true;
        $validated['order_position'] = $validated['order_position'] ?? 0;

        $this->staffService->createStaff($validated);

        return redirect()->route('admin.staff.index')
            ->with('success', 'Data tenaga kependidikan baru berhasil ditambahkan.');
    }

    /**
     * Display staff detail.
     */
    public function show(Staff $staff): View
    {
        return view('admin.staff.show', compact('staff'));
    }

    /**
     * Show form to edit staff record.
     */
    public function edit(Staff $staff): View
    {
        return view('admin.staff.edit', compact('staff'));
    }

    /**
     * Update staff record.
     */
    public function update(Request $request, Staff $staff): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'nip' => ['nullable', 'string', 'max:50', 'unique:staff,nip,' . $staff->id],
            'position' => ['required', 'string', 'max:255'],
            'gender' => ['required', 'in:L,P'],
            'email' => ['nullable', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:50'],
            'order_position' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
            'photo_file' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ], [
            'name.required' => 'Nama tenaga kependidikan wajib diisi.',
            'position.required' => 'Jabatan wajib diisi.',
            'nip.unique' => 'NIP sudah terdaftar pada tenaga kependidikan lain.',
            'photo_file.image' => 'Foto harus berupa berkas gambar.',
        ]);

        $validated['is_active'] = $request->has('is_active');

        $this->staffService->updateStaff($staff, $validated);

        return redirect()->route('admin.staff.index')
            ->with('success', 'Data tenaga kependidikan berhasil diperbarui.');
    }

    /**
     * Destroy staff record.
     */
    public function destroy(Staff $staff): RedirectResponse
    {
        $this->staffService->deleteStaff($staff);

        return redirect()->route('admin.staff.index')
            ->with('success', 'Data tenaga kependidikan berhasil dihapus.');
    }
}
