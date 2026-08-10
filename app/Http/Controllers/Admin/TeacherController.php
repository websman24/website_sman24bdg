<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Teacher;
use App\Services\TeacherService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TeacherController extends Controller
{
    public function __construct(
        protected TeacherService $teacherService
    ) {}

    /**
     * Display listing of teachers with search and filter.
     */
    public function index(Request $request): View
    {
        $search = $request->query('search');
        $status = $request->query('status');
        $gender = $request->query('gender');

        $teachers = $this->teacherService->getPaginatedTeachers(15, $search, $status, $gender);

        return view('admin.teachers.index', compact('teachers', 'search', 'status', 'gender'));
    }

    /**
     * Show form to create teacher.
     */
    public function create(): View
    {
        return view('admin.teachers.create');
    }

    /**
     * Store teacher record.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'nip' => ['nullable', 'string', 'max:50', 'unique:teachers,nip'],
            'subject' => ['required', 'string', 'max:255'],
            'title_prefix' => ['nullable', 'string', 'max:50'],
            'title_suffix' => ['nullable', 'string', 'max:50'],
            'gender' => ['required', 'in:L,P'],
            'email' => ['nullable', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:50'],
            'education' => ['nullable', 'string', 'max:255'],
            'order_position' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
            'photo_file' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ], [
            'name.required' => 'Nama guru wajib diisi.',
            'subject.required' => 'Mata pelajaran yang diampu wajib diisi.',
            'nip.unique' => 'NIP sudah terdaftar.',
            'photo_file.image' => 'Foto harus berupa berkas gambar.',
        ]);

        $validated['is_active'] = $request->has('is_active') ? $request->boolean('is_active') : true;
        $validated['order_position'] = $validated['order_position'] ?? 0;

        $this->teacherService->createTeacher($validated);

        return redirect()->route('admin.teachers.index')
            ->with('success', 'Data pendidik baru berhasil ditambahkan.');
    }

    /**
     * Display teacher detail.
     */
    public function show(Teacher $teacher): View
    {
        return view('admin.teachers.show', compact('teacher'));
    }

    /**
     * Show form to edit teacher.
     */
    public function edit(Teacher $teacher): View
    {
        return view('admin.teachers.edit', compact('teacher'));
    }

    /**
     * Update teacher record.
     */
    public function update(Request $request, Teacher $teacher): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'nip' => ['nullable', 'string', 'max:50', 'unique:teachers,nip,' . $teacher->id],
            'subject' => ['required', 'string', 'max:255'],
            'title_prefix' => ['nullable', 'string', 'max:50'],
            'title_suffix' => ['nullable', 'string', 'max:50'],
            'gender' => ['required', 'in:L,P'],
            'email' => ['nullable', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:50'],
            'education' => ['nullable', 'string', 'max:255'],
            'order_position' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
            'photo_file' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ], [
            'name.required' => 'Nama guru wajib diisi.',
            'subject.required' => 'Mata pelajaran yang diampu wajib diisi.',
            'nip.unique' => 'NIP sudah terdaftar pada pendidik lain.',
            'photo_file.image' => 'Foto harus berupa berkas gambar.',
        ]);

        $validated['is_active'] = $request->has('is_active');

        $this->teacherService->updateTeacher($teacher, $validated);

        return redirect()->route('admin.teachers.index')
            ->with('success', 'Data pendidik berhasil diperbarui.');
    }

    /**
     * Destroy teacher record.
     */
    public function destroy(Teacher $teacher): RedirectResponse
    {
        $this->teacherService->deleteTeacher($teacher);

        return redirect()->route('admin.teachers.index')
            ->with('success', 'Data pendidik berhasil dihapus.');
    }
}
