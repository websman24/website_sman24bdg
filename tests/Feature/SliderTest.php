<?php

namespace Tests\Feature;

use App\Models\Slider;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class SliderTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test admin can create, list, and delete hero image sliders.
     */
    public function test_admin_can_manage_hero_sliders(): void
    {
        Storage::fake('public');

        $admin = User::create([
            'name' => 'Admin SMAN 24',
            'email' => 'admin@sman24bdg.sch.id',
            'password' => Hash::make('Password24!'),
            'role' => 'admin',
        ]);

        $this->actingAs($admin);

        // 1. Get Sliders Index
        $indexResponse = $this->get('/admin/sliders');
        $indexResponse->assertStatus(200);

        // 2. Create Slider with Image
        $image = UploadedFile::fake()->image('hero_banner.jpg', 1920, 1080);
        $createResponse = $this->post('/admin/sliders', [
            'title' => 'Banner Utama SMAN 24 Bandung',
            'subtitle' => 'Subjudul Banner Hero Utama',
            'image_file' => $image,
            'button_text' => 'Lihat Detail',
            'button_url' => '/profil',
            'order_position' => 1,
            'is_active' => '1',
        ]);

        $createResponse->assertRedirect(route('admin.sliders.index'));
        $this->assertDatabaseHas('sliders', ['title' => 'Banner Utama SMAN 24 Bandung']);

        // 3. Check Public Homepage Renders Slider
        $publicResponse = $this->get('/');
        $publicResponse->assertStatus(200);
        $publicResponse->assertSee('Banner Utama SMAN 24 Bandung');

        // 4. Delete Slider
        $slider = Slider::where('title', 'Banner Utama SMAN 24 Bandung')->first();
        $deleteResponse = $this->delete("/admin/sliders/{$slider->id}");
        $deleteResponse->assertRedirect(route('admin.sliders.index'));
        $this->assertDatabaseMissing('sliders', ['id' => $slider->id]);
    }
}
