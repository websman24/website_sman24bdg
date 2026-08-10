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
     * Display listing of teachers.
     */
    public function index(): View
    {
        $teachers = $this->teacherService->getPaginatedTeachers(15);
        return view('admin.teachers.index', compact('teachers'));
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
        ], [
            'name.required' => 'Nama guru wajib diisi.',
            'subject.required' => 'Mata pelajaran yang diampu wajib diisi.',
            'nip.unique' => 'NIP sudah terdaftar.',
        ]);

        $this->teacherService->createTeacher($validated);

        return redirect()->route('admin.teachers.index')
            ->with('success', 'Data pendidik berhasil ditambahkan.');
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
