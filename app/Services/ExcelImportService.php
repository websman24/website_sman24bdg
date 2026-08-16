<?php

namespace App\Services;

use App\Models\Staff;
use App\Models\Teacher;
use Illuminate\Http\UploadedFile;
use PhpOffice\PhpSpreadsheet\IOFactory;

class ExcelImportService
{
    /**
     * Parse spreadsheet file into array of rows.
     */
    public function parseFile(UploadedFile $file): array
    {
        $extension = strtolower($file->getClientOriginalExtension());
        $filePath = $file->getRealPath();

        if (class_exists(IOFactory::class)) {
            $spreadsheet = IOFactory::load($filePath);
            $worksheet = $spreadsheet->getActiveSheet();

            return $worksheet->toArray(null, true, true, true);
        }

        // Fallback for CSV
        if ($extension === 'csv' || $extension === 'txt') {
            $rows = [];
            if (($handle = fopen($filePath, 'r')) !== false) {
                while (($data = fgetcsv($handle, 1000, ',')) !== false) {
                    $rows[] = $data;
                }
                fclose($handle);
            }

            return $rows;
        }

        throw new \Exception('Sistem memerlukan pustaka PhpSpreadsheet untuk membaca berkas .xlsx');
    }

    /**
     * Import Teachers from uploaded Excel/CSV file.
     */
    public function importTeachers(UploadedFile $file): array
    {
        $data = $this->parseFile($file);
        $importedCount = 0;
        $updatedCount = 0;
        $skippedCount = 0;

        if (empty($data)) {
            return ['imported' => 0, 'updated' => 0, 'skipped' => 0];
        }

        // Convert 1-based indexing if array from PhpSpreadsheet
        $rows = array_values($data);
        $header = array_map(fn ($col) => strtolower(trim((string) $col)), $rows[0]);

        for ($i = 1; $i < count($rows); $i++) {
            $row = array_values($rows[$i]);
            if (empty(array_filter($row))) {
                continue; // Skip empty rows
            }

            // Map columns by header or index fallback
            $nip = trim((string) ($row[0] ?? ''));
            $name = trim((string) ($row[1] ?? ''));
            $prefix = trim((string) ($row[2] ?? ''));
            $suffix = trim((string) ($row[3] ?? ''));
            $subject = trim((string) ($row[4] ?? ''));
            $gender = strtoupper(trim((string) ($row[5] ?? 'L')));
            $email = trim((string) ($row[6] ?? ''));
            $phone = trim((string) ($row[7] ?? ''));
            $education = trim((string) ($row[8] ?? ''));
            $statusRaw = strtolower(trim((string) ($row[9] ?? 'aktif')));

            if (empty($name) || empty($subject)) {
                $skippedCount++;

                continue;
            }

            $isActive = ! in_array($statusRaw, ['0', 'false', 'non-aktif', 'tidak', 'inactive']);
            $genderVal = in_array($gender, ['P', 'PEREMPUAN', 'WOMAN', 'FEMALE']) ? 'P' : 'L';

            $teacherData = [
                'nip' => ! empty($nip) ? $nip : null,
                'name' => $name,
                'title_prefix' => ! empty($prefix) ? $prefix : null,
                'title_suffix' => ! empty($suffix) ? $suffix : null,
                'subject' => $subject,
                'gender' => $genderVal,
                'email' => ! empty($email) ? $email : null,
                'phone' => ! empty($phone) ? $phone : null,
                'education' => ! empty($education) ? $education : null,
                'is_active' => $isActive,
            ];

            if (! empty($nip)) {
                $teacher = Teacher::updateOrCreate(['nip' => $nip], $teacherData);
                if ($teacher->wasRecentlyCreated) {
                    $importedCount++;
                } else {
                    $updatedCount++;
                }
            } else {
                Teacher::create($teacherData);
                $importedCount++;
            }
        }

        return [
            'imported' => $importedCount,
            'updated' => $updatedCount,
            'skipped' => $skippedCount,
        ];
    }

    /**
     * Import Educational Staff (Tendik) from uploaded Excel/CSV file.
     */
    public function importStaff(UploadedFile $file): array
    {
        $data = $this->parseFile($file);
        $importedCount = 0;
        $updatedCount = 0;
        $skippedCount = 0;

        if (empty($data)) {
            return ['imported' => 0, 'updated' => 0, 'skipped' => 0];
        }

        $rows = array_values($data);

        for ($i = 1; $i < count($rows); $i++) {
            $row = array_values($rows[$i]);
            if (empty(array_filter($row))) {
                continue;
            }

            $nip = trim((string) ($row[0] ?? ''));
            $name = trim((string) ($row[1] ?? ''));
            $position = trim((string) ($row[2] ?? ''));
            $gender = strtoupper(trim((string) ($row[3] ?? 'L')));
            $email = trim((string) ($row[4] ?? ''));
            $phone = trim((string) ($row[5] ?? ''));
            $statusRaw = strtolower(trim((string) ($row[6] ?? 'aktif')));

            if (empty($name) || empty($position)) {
                $skippedCount++;

                continue;
            }

            $isActive = ! in_array($statusRaw, ['0', 'false', 'non-aktif', 'tidak', 'inactive']);
            $genderVal = in_array($gender, ['P', 'PEREMPUAN', 'WOMAN', 'FEMALE']) ? 'P' : 'L';

            $staffData = [
                'nip' => ! empty($nip) ? $nip : null,
                'name' => $name,
                'position' => $position,
                'gender' => $genderVal,
                'email' => ! empty($email) ? $email : null,
                'phone' => ! empty($phone) ? $phone : null,
                'is_active' => $isActive,
            ];

            if (! empty($nip)) {
                $staff = Staff::updateOrCreate(['nip' => $nip], $staffData);
                if ($staff->wasRecentlyCreated) {
                    $importedCount++;
                } else {
                    $updatedCount++;
                }
            } else {
                Staff::create($staffData);
                $importedCount++;
            }
        }

        return [
            'imported' => $importedCount,
            'updated' => $updatedCount,
            'skipped' => $skippedCount,
        ];
    }
}
