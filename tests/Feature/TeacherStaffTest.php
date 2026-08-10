<?php

namespace Tests\Feature;

use App\Models\Staff;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class TeacherStaffTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_manage_teachers_and_staff_with_search_filter_and_crud(): void
    {
        Storage::fake('public');

        $admin = User::create([
            'name' => 'Admin SMAN 24',
            'email' => 'admin@sman24bdg.sch.id',
            'password' => Hash::make('Password24!'),
            'role' => 'admin',
        ]);

        $this->actingAs($admin);

        // 1. Teacher CRUD (Create, Read, Search, Filter, Detail, Edit, Update, Destroy)
        $teacherIndex = $this->get('/admin/teachers');
        $teacherIndex->assertStatus(200);

        $teacherPhoto = UploadedFile::fake()->image('guru1.jpg', 500, 500);

        $storeTeacher = $this->post('/admin/teachers', [
            'name' => 'Supriatna',
            'title_prefix' => 'Drs.',
            'title_suffix' => 'M.Si.',
            'nip' => '197001011995031001',
            'subject' => 'Fisika Kuantum',
            'gender' => 'L',
            'email' => 'supriatna@sman24bdg.sch.id',
            'phone' => '08123456789',
            'education' => 'S2 Fisika',
            'is_active' => 1,
            'photo_file' => $teacherPhoto,
        ]);
        $storeTeacher->assertRedirect(route('admin.teachers.index'));
        $this->assertDatabaseHas('teachers', ['nip' => '197001011995031001', 'subject' => 'Fisika Kuantum']);

        $teacher = Teacher::where('nip', '197001011995031001')->first();

        // Detail View
        $showTeacher = $this->get("/admin/teachers/{$teacher->id}");
        $showTeacher->assertStatus(200);
        $showTeacher->assertSee('Drs. Supriatna M.Si.');

        // Search & Filter
        $searchResponse = $this->get('/admin/teachers?search=Supriatna&status=active&gender=L');
        $searchResponse->assertStatus(200);
        $searchResponse->assertSee('Fisika Kuantum');

        // Edit & Update
        $editTeacherPage = $this->get("/admin/teachers/{$teacher->id}/edit");
        $editTeacherPage->assertStatus(200);

        $updateTeacher = $this->put("/admin/teachers/{$teacher->id}", [
            'name' => 'Drs. Supriatna Updated',
            'subject' => 'Fisika Terapan',
            'gender' => 'L',
            'is_active' => 1,
        ]);
        $updateTeacher->assertRedirect(route('admin.teachers.index'));
        $this->assertDatabaseHas('teachers', ['name' => 'Drs. Supriatna Updated', 'subject' => 'Fisika Terapan']);

        // 2. Staff CRUD (Create, Read, Search, Filter, Detail, Edit, Update, Destroy)
        $staffIndex = $this->get('/admin/staff');
        $staffIndex->assertStatus(200);

        $staffPhoto = UploadedFile::fake()->image('staff1.jpg', 500, 500);

        $storeStaff = $this->post('/admin/staff', [
            'name' => 'Dewi Sartika',
            'nip' => '198505052010012002',
            'position' => 'Kepala Perpustakaan',
            'gender' => 'P',
            'email' => 'perpus@sman24bdg.sch.id',
            'phone' => '08987654321',
            'is_active' => 1,
            'photo_file' => $staffPhoto,
        ]);
        $storeStaff->assertRedirect(route('admin.staff.index'));
        $this->assertDatabaseHas('staff', ['nip' => '198505052010012002', 'position' => 'Kepala Perpustakaan']);

        $staff = Staff::where('nip', '198505052010012002')->first();

        // Detail View Staff
        $showStaff = $this->get("/admin/staff/{$staff->id}");
        $showStaff->assertStatus(200);
        $showStaff->assertSee('Dewi Sartika');

        // Search & Filter Staff
        $searchStaff = $this->get('/admin/staff?search=Sartika&status=active&gender=P');
        $searchStaff->assertStatus(200);
        $searchStaff->assertSee('Kepala Perpustakaan');

        // Edit & Update Staff
        $editStaffPage = $this->get("/admin/staff/{$staff->id}/edit");
        $editStaffPage->assertStatus(200);

        $updateStaff = $this->put("/admin/staff/{$staff->id}", [
            'name' => 'Dewi Sartika Updated',
            'position' => 'Kepala Laboratorium',
            'gender' => 'P',
            'is_active' => 1,
        ]);
        $updateStaff->assertRedirect(route('admin.staff.index'));
        $this->assertDatabaseHas('staff', ['name' => 'Dewi Sartika Updated', 'position' => 'Kepala Laboratorium']);

        // 3. Public Teachers & Staff Directory
        $publicDir = $this->get('/akademik/guru');
        $publicDir->assertStatus(200);
        $publicDir->assertSee('Supriatna Updated');
        $publicDir->assertSee('Dewi Sartika Updated');

        // 4. Test Template Download & Excel/CSV Import for Teachers & Staff
        $teacherTemplate = $this->get('/admin/teachers/template');
        $teacherTemplate->assertStatus(200);
        $teacherTemplate->assertHeader('Content-Disposition', 'attachment; filename="Format_Import_Guru_SMAN24.csv"');

        $staffTemplate = $this->get('/admin/staff/template');
        $staffTemplate->assertStatus(200);
        $staffTemplate->assertHeader('Content-Disposition', 'attachment; filename="Format_Import_Tendik_SMAN24.csv"');

        // Import CSV for Teachers
        $teacherCsvContent = "NIP,Nama,Gelar Depan,Gelar Belakang,Mata Pelajaran,Jenis Kelamin,Email,Telepon,Pendidikan,Status Aktif\n199901012025011005,Hendra Wijaya,Drs.,M.Pd.,Biologi,L,hendra@sman24bdg.sch.id,0812999,S2,Aktif";
        $teacherCsvFile = UploadedFile::fake()->createWithContent('import_guru.csv', $teacherCsvContent);

        $importTeacherResponse = $this->post('/admin/teachers/import', [
            'excel_file' => $teacherCsvFile,
        ]);
        $importTeacherResponse->assertRedirect(route('admin.teachers.index'));
        $this->assertDatabaseHas('teachers', ['nip' => '199901012025011005', 'name' => 'Hendra Wijaya']);

        // Import CSV for Staff
        $staffCsvContent = "NIP,Nama,Jabatan,Jenis Kelamin,Email,Telepon,Status Aktif\n199902022025012006,Ratna Juwita,Staf Tata Usaha,P,ratna@sman24bdg.sch.id,0899999,Aktif";
        $staffCsvFile = UploadedFile::fake()->createWithContent('import_tendik.csv', $staffCsvContent);

        $importStaffResponse = $this->post('/admin/staff/import', [
            'excel_file' => $staffCsvFile,
        ]);
        $importStaffResponse->assertRedirect(route('admin.staff.index'));
        $this->assertDatabaseHas('staff', ['nip' => '199902022025012006', 'name' => 'Ratna Juwita']);
    }
}
