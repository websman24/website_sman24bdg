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
use App\Models\NewsComment;
use App\Models\OsisMember;
use App\Models\OsisProfile;
use App\Models\Page;
use App\Models\SchoolProfile;
use App\Models\Setting;
use App\Models\Slider;
use App\Models\SpmbQuote;
use App\Models\Staff;
use App\Models\Teacher;
use App\Models\User;
use App\Models\Video;
use App\Models\VisitorLog;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Users Default Roles
        $defaultPassword = env('ADMIN_DEFAULT_PASSWORD', 'Password24!');

        $superadmin = User::updateOrCreate(
            ['email' => 'superadmin@sman24bdg.sch.id'],
            [
                'name' => 'Super Administrator',
                'password' => Hash::make($defaultPassword),
                'role' => 'superadmin',
                'is_active' => true,
            ]
        );

        $admin = User::updateOrCreate(
            ['email' => 'admin@sman24bdg.sch.id'],
            [
                'name' => 'Administrator SMAN 24',
                'password' => Hash::make($defaultPassword),
                'role' => 'admin',
                'is_active' => true,
            ]
        );

        User::updateOrCreate(
            ['email' => 'editor@sman24bdg.sch.id'],
            [
                'name' => 'Tim Humas & Redaksi',
                'password' => Hash::make($defaultPassword),
                'role' => 'editor',
                'is_active' => true,
            ]
        );

        User::updateOrCreate(
            ['email' => 'guru@sman24bdg.sch.id'],
            [
                'name' => 'Guru & Tenaga Pendidik',
                'password' => Hash::make($defaultPassword),
                'role' => 'guru',
                'is_active' => true,
            ]
        );

        $this->command->info("Akun Superadmin, Admin, Editor, & Guru berhasil disiapkan dengan password: {$defaultPassword}");

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

        SchoolProfile::updateOrCreate(
            ['key' => 'sejarah'],
            [
                'title' => 'Sejarah SMA Negeri 24 Bandung',
                'content' => 'SMA Negeri 24 Bandung didirikan dengan tujuan untuk memenuhi kebutuhan masyarakat akan pendidikan menengah atas yang berkualitas di wilayah Bandung Timur. Sejak awal berdirinya, sekolah ini telah banyak mencetak lulusan berprestasi.',
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
        Setting::updateOrCreate(
            ['key' => 'total_students'],
            ['value' => '1.000+', 'group' => 'general', 'type' => 'text', 'label' => 'Total Peserta Didik']
        );
        Setting::updateOrCreate(
            ['key' => 'spmb_quote'],
            ['value' => 'Pendidikan adalah tiket ke masa depan, hari esok dimiliki oleh orang-orang yang mempersiapkannya hari ini. — SMAN 24 Bandung', 'group' => 'general', 'type' => 'text', 'label' => 'Kata Bijak Layanan SPMB']
        );
        Setting::updateOrCreate(
            ['key' => 'instagram_url'],
            ['value' => 'https://www.instagram.com/sman24bdg', 'group' => 'contact', 'type' => 'text', 'label' => 'Instagram URL']
        );
        Setting::updateOrCreate(
            ['key' => 'facebook_url'],
            ['value' => 'https://www.facebook.com/sman24bandung', 'group' => 'contact', 'type' => 'text', 'label' => 'Facebook URL']
        );
        Setting::updateOrCreate(
            ['key' => 'youtube_url'],
            ['value' => 'https://www.youtube.com/@sman24bandung', 'group' => 'contact', 'type' => 'text', 'label' => 'YouTube URL']
        );
        Setting::updateOrCreate(
            ['key' => 'tiktok_url'],
            ['value' => 'https://www.tiktok.com/@sman24bdg', 'group' => 'contact', 'type' => 'text', 'label' => 'TikTok URL']
        );

        SpmbQuote::updateOrCreate(
            ['id' => 1],
            [
                'quote_text' => 'Pendidikan adalah tiket ke masa depan, hari esok dimiliki oleh orang-orang yang mempersiapkannya hari ini.',
                'author_source' => 'SMAN 24 Bandung',
                'is_active' => true,
                'order_position' => 1,
            ]
        );

        // 17. Default Hero Sliders
        Slider::updateOrCreate(
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

        Slider::updateOrCreate(
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

        // 18. OSIS Profile & Sample Members (Phase 1 & 2)
        OsisProfile::updateOrCreate(
            ['id' => 1],
            [
                'cabinet_name' => 'Kabinet Cakra Baskara',
                'period' => '2025/2026',
                'tagline' => 'Bersinergi, Berkarakter, Menginspirasi',
                'vision' => 'Mewujudkan OSIS SMAN 24 Bandung sebagai wadah aspirasi dan pengembangan potensi siswa yang berakhlak mulia, cerdas, kreatif, dan berwawasan global.',
                'mission' => "1. Menumbuhkan keimanan dan ketaqwaan kepada Tuhan YME dalam setiap kegiatan.\n2. Mendorong peningkatan prestasi akademik dan non-akademik siswa.\n3. Mengembangkan kreativitas, inovasi, dan jiwa kepemimpinan siswa.\n4. Menjalin komunikasi harmonis antara siswa, pihak sekolah, dan alumni.",
                'leader_name' => 'Muhammad Rizky Pratama',
                'leader_welcome' => 'Selamat datang di portal informasi OSIS SMAN 24 Bandung. Kami mengundang seluruh siswa untuk aktif berpartisipasi dalam setiap kegiatan positif demi kemajuan bersama.',
                'instagram_url' => 'https://instagram.com/osis24bdg',
                'tiktok_url' => 'https://tiktok.com/@osis24bdg',
                'youtube_url' => 'https://youtube.com/@osis24bdg',
            ]
        );

        // Sample BPH & Sekbid Members
        $sampleMembers = [
            [
                'name' => 'Muhammad Rizky Pratama',
                'position' => 'Ketua OSIS',
                'department' => 'bph',
                'class_grade' => 'XI MIPA 1',
                'instagram' => '@rizky.pratama',
                'motto' => 'Pemimpin adalah pelayan bagi sesama.',
                'order_position' => 1,
                'is_active' => true,
            ],
            [
                'name' => 'Nabila Az-Zahra',
                'position' => 'Wakil Ketua OSIS',
                'department' => 'bph',
                'class_grade' => 'XI IPS 2',
                'instagram' => '@nabila.azzahra',
                'motto' => 'Bekerja dengan hati, menginspirasi dengan aksi.',
                'order_position' => 2,
                'is_active' => true,
            ],
            [
                'name' => 'Fajar Ramadhan',
                'position' => 'Sekretaris Umum',
                'department' => 'bph',
                'class_grade' => 'XI MIPA 3',
                'instagram' => '@fajar.rmdhn',
                'motto' => 'Tertib administrasi, lancar organisasi.',
                'order_position' => 3,
                'is_active' => true,
            ],
            [
                'name' => 'Salma Putri Hidayat',
                'position' => 'Bendahara Umum',
                'department' => 'bph',
                'class_grade' => 'XI MIPA 2',
                'instagram' => '@salma.ph',
                'motto' => 'Transparan, akuntabel, dan amanah.',
                'order_position' => 4,
                'is_active' => true,
            ],
            [
                'name' => 'Dimas Arya Putra',
                'position' => 'Ketua Sekbid 1 (Keagamaan)',
                'department' => 'sekbid_1',
                'class_grade' => 'X-2',
                'instagram' => '@dimas.arya',
                'motto' => 'Menjadikan iman sebagai fondasi utama.',
                'order_position' => 5,
                'is_active' => true,
            ],
            [
                'name' => 'Aisyah Putri Maharani',
                'position' => 'Ketua Sekbid 9 (Medkref & TIK)',
                'department' => 'sekbid_9',
                'class_grade' => 'XI MIPA 4',
                'instagram' => '@aisyah.creatives',
                'motto' => 'Kreativitas tanpa batas di era digital.',
                'order_position' => 6,
                'is_active' => true,
            ],
            [
                'name' => 'Bagas Kurniawan',
                'position' => 'Ketua MPK',
                'department' => 'mpk',
                'class_grade' => 'XII MIPA 1',
                'instagram' => '@bagas.krn',
                'motto' => 'Mengawal aspirasi demi keadilan bersama.',
                'order_position' => 7,
                'is_active' => true,
            ],
        ];

        foreach ($sampleMembers as $m) {
            OsisMember::updateOrCreate(
                ['name' => $m['name']],
                $m
            );
        }

        // 19. Sample News Comments
        $sampleNews = News::first();
        if ($sampleNews) {
            NewsComment::updateOrCreate(
                ['news_id' => $sampleNews->id, 'name' => 'Fathan Al-Ghifari'],
                [
                    'email' => 'fathan@alumni.sman24bdg.sch.id',
                    'comment' => 'Selamat atas peluncuran website resmi terbaru SMA Negeri 24 Bandung! Tampilannya sangat modern, responsif, dan informatif.',
                    'is_approved' => true,
                    'created_at' => now()->subHours(5),
                ]
            );

            NewsComment::updateOrCreate(
                ['news_id' => $sampleNews->id, 'name' => 'Zahra Amelia'],
                [
                    'email' => 'zahra.amelia@gmail.com',
                    'comment' => 'Keren sekali websitenya! Memudahkan calon siswa dan orang tua untuk melihat informasi kegiatan sekolah.',
                    'is_approved' => true,
                    'created_at' => now()->subHours(2),
                ]
            );
        }

        // 20. Sample 14-Day Visitor Analytics
        if (VisitorLog::count() === 0) {
            $pages = ['/', 'berita', 'profil', 'akademik/guru', 'kesiswaan/osis', 'kesiswaan/ekstrakurikuler', 'spmb/pendaftar'];
            $sampleIps = ['192.168.1.10', '192.168.1.15', '192.168.1.20', '192.168.1.25', '180.252.16.88', '114.125.72.102', '125.160.10.45', '182.253.90.11'];

            for ($daysAgo = 13; $daysAgo >= 0; $daysAgo--) {
                $vDate = now()->subDays($daysAgo)->toDateString();
                $dailyHits = rand(25, 60);

                for ($h = 0; $h < $dailyHits; $h++) {
                    VisitorLog::create([
                        'ip_address' => $sampleIps[array_rand($sampleIps)],
                        'page_url' => $pages[array_rand($pages)],
                        'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64)',
                        'visit_date' => $vDate,
                        'created_at' => now()->subDays($daysAgo)->addMinutes(rand(10, 1400)),
                    ]);
                }
            }
        }
    }
}
