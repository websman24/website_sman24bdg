<?php

namespace Tests\Feature;

use App\Models\AcademicCalendar;
use App\Models\Achievement;
use App\Models\Announcement;
use App\Models\Document;
use App\Models\Event;
use App\Models\Extracurricular;
use App\Models\Gallery;
use App\Models\GalleryItem;
use App\Models\News;
use App\Models\NewsCategory;
use App\Models\Page;
use App\Models\SchoolProfile;
use App\Models\Setting;
use App\Models\Staff;
use App\Models\Teacher;
use App\Models\User;
use App\Models\Video;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DomainEntitiesTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test all 17 domain entities tables and relationships.
     */
    public function test_all_17_domain_entities_function_correctly(): void
    {
        // 1. User
        $user = User::create([
            'name' => 'Admin Test',
            'email' => 'admin.test@sman24bdg.sch.id',
            'password' => bcrypt('Password24!'),
            'role' => 'admin',
        ]);
        $this->assertTrue($user->isAdmin());

        // 2. SchoolProfile
        $profile = SchoolProfile::create([
            'key' => 'sejarah',
            'title' => 'Sejarah Sekolah',
            'content' => 'Sejarah SMAN 24 Bandung',
        ]);
        $this->assertDatabaseHas('school_profiles', ['key' => 'sejarah']);

        // 3. Page
        $page = Page::create([
            'title' => 'Panduan',
            'slug' => 'panduan-sekolah',
            'content' => 'Isi panduan',
        ]);
        $this->assertDatabaseHas('pages', ['slug' => 'panduan-sekolah']);

        // 4. Teacher
        $teacher = Teacher::create([
            'nip' => '198000000000000001',
            'name' => 'Budi',
            'subject' => 'Fisika',
        ]);
        $this->assertDatabaseHas('teachers', ['nip' => '198000000000000001']);

        // 5. Staff
        $staff = Staff::create([
            'name' => 'Siti',
            'position' => 'Staf TU',
        ]);
        $this->assertDatabaseHas('staff', ['name' => 'Siti']);

        // 6. NewsCategory & 7. News
        $category = NewsCategory::create(['name' => 'Akademik', 'slug' => 'akademik']);
        $news = News::create([
            'category_id' => $category->id,
            'author_id' => $user->id,
            'title' => 'Berita Akademik',
            'slug' => 'berita-akademik',
            'content' => 'Isi berita',
        ]);
        $this->assertEquals($category->id, $news->category->id);
        $this->assertEquals($user->id, $news->author->id);

        // 8. Announcement
        $announcement = Announcement::create([
            'author_id' => $user->id,
            'title' => 'Pengumuman Penting',
            'slug' => 'pengumuman-penting',
            'content' => 'Isi pengumuman',
        ]);
        $this->assertEquals($user->id, $announcement->author->id);

        // 9. Event
        $event = Event::create([
            'author_id' => $user->id,
            'title' => 'Kegiatan Donor Darah',
            'slug' => 'kegiatan-donor-darah',
            'location' => 'Aula',
            'start_date' => now(),
        ]);
        $this->assertEquals($user->id, $event->author->id);

        // 10. Achievement
        $achievement = Achievement::create([
            'title' => 'Juara 1 OSN',
            'winner_name' => 'Ahmad',
            'event_name' => 'OSN 2026',
            'achievement_year' => 2026,
        ]);
        $this->assertDatabaseHas('achievements', ['title' => 'Juara 1 OSN']);

        // 11. Extracurricular
        $extra = Extracurricular::create([
            'name' => 'Pramuka',
            'slug' => 'pramuka',
            'category' => 'Bela Negara',
        ]);
        $this->assertDatabaseHas('extracurriculars', ['slug' => 'pramuka']);

        // 12. Gallery & 13. GalleryItem
        $gallery = Gallery::create([
            'author_id' => $user->id,
            'title' => 'Album Upacara',
            'slug' => 'album-upacara',
        ]);
        $item = GalleryItem::create([
            'gallery_id' => $gallery->id,
            'image_path' => 'photos/1.jpg',
        ]);
        $this->assertEquals(1, $gallery->items()->count());

        // 14. Video
        $video = Video::create([
            'title' => 'Video Profil',
            'youtube_url' => 'https://youtube.com/watch?v=123',
            'youtube_id' => '123',
        ]);
        $this->assertDatabaseHas('videos', ['youtube_id' => '123']);

        // 15. Document
        $doc = Document::create([
            'author_id' => $user->id,
            'title' => 'Panduan SPMB',
            'category' => 'SPMB',
            'file_path' => 'docs/spmb.pdf',
        ]);
        $this->assertEquals($user->id, $doc->author->id);

        // 16. AcademicCalendar
        $calendar = AcademicCalendar::create([
            'academic_year' => '2026/2027',
            'semester' => 'odd',
            'title' => 'Libur Semester',
            'start_date' => now(),
        ]);
        $this->assertDatabaseHas('academic_calendars', ['academic_year' => '2026/2027']);

        // 17. Setting
        $setting = Setting::create([
            'key' => 'site_name',
            'value' => 'SMAN 24 Bandung',
            'label' => 'Nama Situs',
        ]);
        $this->assertEquals('SMAN 24 Bandung', Setting::getValue('site_name'));
    }
}
