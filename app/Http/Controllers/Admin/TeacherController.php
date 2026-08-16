<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Teacher;
use App\Services\ExcelImportService;
use App\Services\TeacherService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class TeacherController extends Controller
{
    public function __construct(
        protected TeacherService $teacherService,
        protected ExcelImportService $excelImportService
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
            'nip' => ['nullable', 'string', 'max:50', 'unique:teachers,nip,'.$teacher->id],
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

    /**
     * Bulk delete selected teacher records.
     *
     * Security: validates ids as array of integers before processing.
     */
    public function bulkDelete(Request $request): RedirectResponse
    {
        $request->validate([
            'ids' => ['required', 'array', 'min:1'],
            'ids.*' => ['integer', 'min:1'],
        ]);

        $ids = $request->input('ids', []);

        if (empty($ids)) {
            return redirect()->route('admin.teachers.index')->with('error', 'Tidak ada data pendidik yang dipilih.');
        }

        $teachers = Teacher::whereIn('id', $ids)->get();
        foreach ($teachers as $teacher) {
            $this->teacherService->deleteTeacher($teacher);
        }

        return redirect()->route('admin.teachers.index')
            ->with('success', count($teachers).' data pendidik berhasil dihapus secara massal.');
    }

    /**
     * Import teachers from Excel/CSV file.
     */
    public function import(Request $request): RedirectResponse
    {
        $request->validate([
            'excel_file' => ['required', 'file', 'mimes:xlsx,xls,csv,txt', 'max:5120'],
        ], [
            'excel_file.required' => 'Berkas Excel / CSV wajib diunggah.',
            'excel_file.mimes' => 'Format berkas harus .xlsx, .xls, atau .csv.',
        ]);

        $result = $this->excelImportService->importTeachers($request->file('excel_file'));

        $msg = "Impor selesai: {$result['imported']} data baru ditambahkan";
        if ($result['updated'] > 0) {
            $msg .= ", {$result['updated']} data diperbarui";
        }
        if ($result['skipped'] > 0) {
            $msg .= ", {$result['skipped']} baris dilewati (format tidak lengkap)";
        }

        return redirect()->route('admin.teachers.index')->with('success', $msg.'.');
    }

    /**
     * Download Excel/CSV template for teachers.
     */
    public function downloadTemplate(): StreamedResponse
    {
        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="Format_Import_Guru_SMAN24.csv"',
        ];

        return response()->stream(function () {
            $file = fopen('php://output', 'w');
            // Add UTF-8 BOM for Excel compatibility
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));

            fputcsv($file, ['NIP', 'Nama', 'Gelar Depan', 'Gelar Belakang', 'Mata Pelajaran', 'Jenis Kelamin', 'Email', 'Telepon', 'Pendidikan', 'Status Aktif']);
            fputcsv($file, ['198001012006041002', 'Budi Santoso', 'Drs.', 'M.Pd.', 'Matematika', 'L', 'budi.santoso@sman24bdg.sch.id', '08123456789', 'S2 Pendidikan Matematika', 'Aktif']);
            fputcsv($file, ['198505122010012003', 'Siti Aminah', 'S.Pd.', '', 'Fisika', 'P', 'siti.aminah@sman24bdg.sch.id', '08987654321', 'S1 Fisika', 'Aktif']);

            fclose($file);
        }, 200, $headers);
    }
}
