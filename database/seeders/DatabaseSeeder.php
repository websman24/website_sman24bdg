<?php

namespace Database\Seeders;

use App\Models\AcademicCalendar;
use App\Models\Achievement;
use App\Models\Announcement;
use App\Models\Document;
use App\Models\Event;
use App\Models\Extracurricular;
use App\Models\News;
use App\Models\NewsCategory;
use App\Models\Page;
use App\Models\SchoolProfile;
use App\Models\Setting;
use App\Models\Staff;
use App\Models\Teacher;
use App\Models\User;
use App\Models\Video;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Users
        $admin = User::updateOrCreate(
            ['email' => 'admin@sman24bdg.sch.id'],
            [
                'name' => 'Administrator SMAN 24',
                'password' => Hash::make('Password24!'),
                'role' => 'admin',
                'is_active' => true,
            ]
        );

        // 2. School Profiles
        SchoolProfile::updateOrCreate(
            ['key' => 'visi_misi'],
            [
                'title' => 'Visi dan Misi SMAN 24 Bandung',
                'content' => 'Visi: Terwujudnya sekolah berkarakter, unggul dalam prestasi akademik dan non-akademik, serta berwawasan global.',
                'is_published' => true,
            ]
        );

        SchoolProfile::updateOrCreate(
            ['key' => 'sambutan_kepala_sekolah'],
            [
                'title' => 'Sambutan Kepala Sekolah SMAN 24 Bandung',
                'content' => 'Selamat datang di Website Resmi SMA Negeri 24 Bandung. Kami berkomitmen memberikan layanan pendidikan terbaik bagi putra-putri bangsa di Kota Bandung.',
                'meta_json' => ['headmaster_name' => 'Drs. H. Solihin, M.Pd.', 'nip' => '197505122000031001'],
                'is_published' => true,
            ]
        );

        // 3. Pages
        Page::updateOrCreate(
            ['slug' => 'fasilitas-sekolah'],
            [
                'title' => 'Fasilitas SMA Negeri 24 Bandung',
                'content' => 'Fasilitas sekolah meliputi Perpustakaan Digital, Lab Komputer, Lab IPA, Lapangan Olahraga, Musala, dan Ruang Multimedia.',
                'status' => 'published',
            ]
        );

        // 4. Teachers
        Teacher::updateOrCreate(
            ['nip' => '198001012006041002'],
            [
                'name' => 'Budi Santoso',
                'title_prefix' => 'Drs.',
                'title_suffix' => 'M.Pd.',
                'subject' => 'Matematika',
                'gender' => 'L',
                'email' => 'budi.santoso@sman24bdg.sch.id',
                'is_active' => true,
            ]
        );

        // 5. Staff
        Staff::updateOrCreate(
            ['nip' => '198502152010012003'],
            [
                'name' => 'Siti Nurhaliza',
                'position' => 'Kepala Tata Usaha',
                'gender' => 'P',
                'email' => 'tu@sman24bdg.sch.id',
                'is_active' => true,
            ]
        );

        // 6. News Categories
        $catKegiatan = NewsCategory::updateOrCreate(
            ['slug' => 'kegiatan-sekolah'],
            ['name' => 'Kegiatan Sekolah', 'description' => 'Kabar seputar kegiatan dan acara di SMAN 24 Bandung.']
        );

        // 7. News
        News::updateOrCreate(
            ['slug' => 'peluncuran-website-resmi-sman-24-bandung'],
            [
                'category_id' => $catKegiatan->id,
                'author_id' => $admin->id,
                'title' => 'Peluncuran Website Resmi SMA Negeri 24 Bandung',
                'excerpt' => 'SMA Negeri 24 Bandung meluncurkan sistem informasi berbasis Laravel 12 untuk meningkatkan transparansi publik.',
                'content' => 'Dengan penuh rasa syukur, SMA Negeri 24 Bandung secara resmi meluncurkan portal informasi publik terbaru.',
                'status' => 'published',
                'published_at' => now(),
            ]
        );

        // 8. Announcements
        Announcement::updateOrCreate(
            ['slug' => 'pengumuman-persiapan-spmb-2026'],
            [
                'author_id' => $admin->id,
                'title' => 'Pengumuman Persiapan SPMB SMAN 24 Bandung',
                'content' => 'Informasi pendaftaran dan daftar ulang peserta didik baru dapat diakses melalui portal SPMB.',
                'is_pinned' => true,
                'status' => 'published',
                'published_at' => now(),
            ]
        );

        // 9. Events
        Event::updateOrCreate(
            ['slug' => 'rapat-orang-tua-siswa-tahun-ajaran-2026'],
            [
                'author_id' => $admin->id,
                'title' => 'Rapat Orang Tua Siswa Kelas X',
                'description' => 'Sosialisasi program sekolah dan perkenalan wali kelas.',
                'location' => 'Aula Utama SMAN 24 Bandung',
                'start_date' => now()->addDays(7),
                'end_date' => now()->addDays(7)->addHours(3),
                'status' => 'upcoming',
            ]
        );

        // 10. Achievements
        Achievement::updateOrCreate(
            ['title' => 'Juara 1 Lomba Karya Tulis Ilmiah Remaja Tingkat Kota Bandung'],
            [
                'category' => 'akademik',
                'level' => 'kota',
                'winner_name' => 'Tim Kir SMAN 24',
                'event_name' => 'Olimpiade Sains & Karya Ilmiah 2026',
                'achievement_year' => 2026,
                'description' => 'Meraih peringkat pertama dalam kompetisi karya tulis ilmiah.',
            ]
        );

        // 11. Extracurriculars
        Extracurricular::updateOrCreate(
            ['slug' => 'paskibra-sman-24'],
            [
                'name' => 'Paskibra SMAN 24 Bandung',
                'category' => 'Bela Negara',
                'mentor_name' => 'Dedi Kurniawan, S.Pd.',
                'schedule' => 'Setiap Rabu & Sabtu 15:30 WIB',
                'description' => 'Pasukan Pengibar Bendera SMA Negeri 24 Bandung.',
                'is_active' => true,
            ]
        );

        // 12. Videos
        Video::updateOrCreate(
            ['youtube_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ'],
            [
                'title' => 'Profil SMA Negeri 24 Bandung',
                'youtube_id' => 'dQw4w9WgXcQ',
                'description' => 'Video perkenalan lingkungan dan fasilitas SMAN 24 Bandung.',
                'is_featured' => true,
            ]
        );

        // 13. Documents
        Document::updateOrCreate(
            ['title' => 'Formulir Pendaftaran SPMB SMAN 24 Bandung'],
            [
                'author_id' => $admin->id,
                'category' => 'SPMB',
                'file_path' => 'documents/form_spmb_sman24.pdf',
                'file_size' => 1024000,
                'file_type' => 'pdf',
                'description' => 'Dokumen formulir verifikasi kelengkapan berkas murid baru.',
            ]
        );

        // 14. Academic Calendars
        AcademicCalendar::updateOrCreate(
            ['title' => 'Penilaian Tengah Semester Ganjil'],
            [
                'academic_year' => '2026/2027',
                'semester' => 'odd',
                'start_date' => now()->addMonth(),
                'end_date' => now()->addMonth()->addDays(6),
                'description' => 'Ujian tengah semester gasal.',
                'color_code' => '#10b981',
            ]
        );

        // 15. Settings
        Setting::updateOrCreate(
            ['key' => 'school_name'],
            ['value' => 'SMA Negeri 24 Bandung', 'group' => 'general', 'type' => 'text', 'label' => 'Nama Sekolah']
        );
        Setting::updateOrCreate(
            ['key' => 'school_address'],
            ['value' => 'Jl. A.H. Nasution No. 27, Kota Bandung, Jawa Barat 40614', 'group' => 'contact', 'type' => 'text', 'label' => 'Alamat Sekolah']
        );
        Setting::updateOrCreate(
            ['key' => 'school_phone'],
            ['value' => '(022) 7800540', 'group' => 'contact', 'type' => 'text', 'label' => 'Telepon Sekolah']
        );
        Setting::updateOrCreate(
            ['key' => 'school_email'],
            ['value' => 'info@sman24bdg.sch.id', 'group' => 'contact', 'type' => 'text', 'label' => 'Email Sekolah']
        );
        Setting::updateOrCreate(
            ['key' => 'school_npsn'],
            ['value' => '20219736', 'group' => 'general', 'type' => 'text', 'label' => 'NPSN Sekolah']
        );
        Setting::updateOrCreate(
            ['key' => 'school_accreditation'],
            ['value' => 'A (Unggul)', 'group' => 'general', 'type' => 'text', 'label' => 'Akreditasi Sekolah']
        );
        Setting::updateOrCreate(
            ['key' => 'school_motto'],
            ['value' => 'Cerdas, Berkarakter, Berbudaya, dan Berwawasan Global', 'group' => 'general', 'type' => 'text', 'label' => 'Motto Sekolah']
        );
        Setting::updateOrCreate(
            ['key' => 'school_logo'],
            ['value' => 'storage/uploads/settings/school_logo.png', 'group' => 'general', 'type' => 'image', 'label' => 'Logo Sekolah']
        );
        Setting::updateOrCreate(
            ['key' => 'principal_name'],
            ['value' => 'Drs. H. Solihin, M.Pd.', 'group' => 'general', 'type' => 'text', 'label' => 'Nama Kepala Sekolah']
        );
        Setting::updateOrCreate(
            ['key' => 'principal_title'],
            ['value' => 'Kepala SMA Negeri 24 Bandung', 'group' => 'general', 'type' => 'text', 'label' => 'Jabatan Kepala Sekolah']
        );

        // 17. Default Hero Sliders
        \App\Models\Slider::updateOrCreate(
            ['title' => 'Selamat Datang di SMA Negeri 24 Bandung'],
            [
                'subtitle' => 'Sekolah Berkarakter, Unggul dalam Prestasi Akademik & Non-Akademik, Berwawasan Global.',
                'image_path' => 'storage/uploads/sliders/sample_slider1.jpg',
                'button_text' => 'Jelajahi Profil Sekolah',
                'button_url' => '/profil',
                'order_position' => 1,
                'is_active' => true,
            ]
        );

        \App\Models\Slider::updateOrCreate(
            ['title' => 'Penerimaan Murid Baru (SPMB) 2026/2027'],
            [
                'subtitle' => 'Informasi Resmi Pendaftaran, Syarat Berkas, dan Alur Verifikasi Daftar Ulang.',
                'image_path' => 'storage/uploads/sliders/sample_slider2.jpg',
                'button_text' => 'Layanan SPMB',
                'button_url' => '/spmb/pendaftar',
                'order_position' => 2,
                'is_active' => true,
            ]
        );
    }
}
