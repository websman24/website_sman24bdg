<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Staff;
use App\Services\ExcelImportService;
use App\Services\StaffService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class StaffController extends Controller
{
    public function __construct(
        protected StaffService $staffService,
        protected ExcelImportService $excelImportService
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
            'nip' => ['nullable', 'string', 'max:50', 'unique:staff,nip,'.$staff->id],
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

    /**
     * Import staff from Excel/CSV file.
     */
    public function import(Request $request): RedirectResponse
    {
        $request->validate([
            'excel_file' => ['required', 'file', 'mimes:xlsx,xls,csv,txt', 'max:5120'],
        ], [
            'excel_file.required' => 'Berkas Excel / CSV wajib diunggah.',
            'excel_file.mimes' => 'Format berkas harus .xlsx, .xls, atau .csv.',
        ]);

        $result = $this->excelImportService->importStaff($request->file('excel_file'));

        $msg = "Impor selesai: {$result['imported']} data baru ditambahkan";
        if ($result['updated'] > 0) {
            $msg .= ", {$result['updated']} data diperbarui";
        }
        if ($result['skipped'] > 0) {
            $msg .= ", {$result['skipped']} baris dilewati (format tidak lengkap)";
        }

        return redirect()->route('admin.staff.index')->with('success', $msg.'.');
    }

    /**
     * Download Excel/CSV template for staff.
     */
    public function downloadTemplate(): StreamedResponse
    {
        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="Format_Import_Tendik_SMAN24.csv"',
        ];

        return response()->stream(function () {
            $file = fopen('php://output', 'w');
            // Add UTF-8 BOM for Excel compatibility
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));

            fputcsv($file, ['NIP', 'Nama', 'Jabatan', 'Jenis Kelamin', 'Email', 'Telepon', 'Status Aktif']);
            fputcsv($file, ['198502152010012003', 'Siti Nurhaliza', 'Kepala Tata Usaha', 'P', 'tu@sman24bdg.sch.id', '08123456789', 'Aktif']);
            fputcsv($file, ['199003122015021004', 'Ahmad Subagja', 'Staf Laboratorium IPA', 'L', 'ahmad@sman24bdg.sch.id', '08987654321', 'Aktif']);

            fclose($file);
        }, 200, $headers);
    }
}
