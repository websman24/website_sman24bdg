<?php

namespace Tests\Feature;

use App\Models\OsisMember;
use App\Models\OsisProfile;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class OsisModuleTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_manage_osis_profile_and_members(): void
    {
        Storage::fake('public');

        $admin = User::create([
            'name' => 'Kesiswaan Admin',
            'email' => 'kesiswaan@sman24bdg.sch.id',
            'password' => Hash::make('Password24!'),
            'role' => 'admin',
        ]);

        // 1. Guest is redirected
        $guestResponse = $this->get('/admin/osis');
        $guestResponse->assertRedirect(route('admin.login'));

        $this->actingAs($admin);

        // 2. Admin can view OSIS index page
        $indexResponse = $this->get('/admin/osis');
        $indexResponse->assertStatus(200);
        $indexResponse->assertSee('Manajemen OSIS & MPK', false);
        $indexResponse->assertSee('Profil & Kabinet OSIS', false);

        // 3. Admin can update OSIS Profile (Tahap 1)
        $leaderPhoto = UploadedFile::fake()->image('ketua.jpg', 400, 400);
        $updateProfile = $this->post('/admin/osis/profile', [
            'cabinet_name' => 'Kabinet Cakra Baskara 2026',
            'period' => '2025/2026',
            'tagline' => 'Bersinergi Tanpa Henti',
            'vision' => 'Visi baru OSIS 24',
            'mission' => "1. Misi kesatu\n2. Misi kedua",
            'leader_name' => 'Muhammad Rizky Pratama',
            'leader_welcome' => 'Selamat datang di era baru OSIS SMAN 24.',
            'instagram_url' => 'https://instagram.com/osis24bdg',
            'leader_photo' => $leaderPhoto,
        ]);
        $updateProfile->assertRedirect(route('admin.osis.index', ['tab' => 'profile']));
        $this->assertDatabaseHas('osis_profiles', [
            'cabinet_name' => 'Kabinet Cakra Baskara 2026',
            'tagline' => 'Bersinergi Tanpa Henti',
        ]);

        // 4. Admin can create OSIS Member (Tahap 2)
        $memberPhoto = UploadedFile::fake()->image('anggota.jpg', 300, 300);
        $createMember = $this->post('/admin/osis/members', [
            'name' => 'Ahmad Fauzan',
            'position' => 'Ketua Sekbid 3 (Bela Negara)',
            'department' => 'sekbid_3',
            'class_grade' => 'XI MIPA 2',
            'instagram' => '@ahmad.fauzan',
            'motto' => 'Disiplin dan Tangguh.',
            'order_position' => 10,
            'is_active' => 1,
            'photo_file' => $memberPhoto,
        ]);
        $createMember->assertRedirect(route('admin.osis.index', ['tab' => 'members']));
        $this->assertDatabaseHas('osis_members', [
            'name' => 'Ahmad Fauzan',
            'position' => 'Ketua Sekbid 3 (Bela Negara)',
            'department' => 'sekbid_3',
        ]);

        $member = OsisMember::where('name', 'Ahmad Fauzan')->first();

        // 5. Admin can search and filter OSIS members
        $searchResponse = $this->get('/admin/osis?tab=members&search=Fauzan&department=sekbid_3&status=1');
        $searchResponse->assertStatus(200);
        $searchResponse->assertSee('Ahmad Fauzan');
        $searchResponse->assertSee('Ketua Sekbid 3 (Bela Negara)');

        // 6. Admin can edit & update member
        $editPage = $this->get("/admin/osis/members/{$member->id}/edit");
        $editPage->assertStatus(200);
        $editPage->assertSee('Edit Data Pengurus OSIS & MPK', false);

        $updateMember = $this->put("/admin/osis/members/{$member->id}", [
            'name' => 'Ahmad Fauzan Updated',
            'position' => 'Koordinator Sekbid 3',
            'department' => 'sekbid_3',
            'class_grade' => 'XI MIPA 2',
            'is_active' => 1,
        ]);
        $updateMember->assertRedirect(route('admin.osis.index', ['tab' => 'members']));
        $this->assertDatabaseHas('osis_members', [
            'name' => 'Ahmad Fauzan Updated',
            'position' => 'Koordinator Sekbid 3',
        ]);

        // 7. Admin can delete member
        $deleteMember = $this->delete("/admin/osis/members/{$member->id}");
        $deleteMember->assertRedirect(route('admin.osis.index', ['tab' => 'members']));
        $this->assertDatabaseMissing('osis_members', ['id' => $member->id]);

        // 8. Bulk delete members
        $memberA = OsisMember::create([
            'name' => 'Member A',
            'position' => 'Staf 1',
            'department' => 'sekbid_1',
        ]);
        $memberB = OsisMember::create([
            'name' => 'Member B',
            'position' => 'Staf 2',
            'department' => 'sekbid_2',
        ]);

        $bulkDelete = $this->post('/admin/osis/members/bulk-delete', [
            'ids' => [$memberA->id, $memberB->id],
        ]);
        $bulkDelete->assertRedirect(route('admin.osis.index', ['tab' => 'members']));
        $this->assertDatabaseMissing('osis_members', ['id' => $memberA->id]);
        $this->assertDatabaseMissing('osis_members', ['id' => $memberB->id]);
    }
}
