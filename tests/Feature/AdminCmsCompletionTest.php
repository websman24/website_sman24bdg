<?php

namespace Tests\Feature;

use App\Models\Teacher;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AdminCmsCompletionTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_dashboard_user_management_and_bulk_actions(): void
    {
        $superadmin = User::create([
            'name' => 'Super Administrator SMAN 24',
            'email' => 'superadmin@sman24bdg.sch.id',
            'password' => Hash::make('Password24!'),
            'role' => 'superadmin',
            'is_active' => true,
        ]);

        $this->actingAs($superadmin);

        // 1. Dashboard View & Recent Activity Feed
        $dashboard = $this->get(route('admin.dashboard'));
        $dashboard->assertStatus(200);
        $dashboard->assertSee('Selamat Datang');
        $dashboard->assertSee('Berita Artikel');
        $dashboard->assertSee('Agenda Sekolah');

        // 2. User Management CRUD
        $createUser = $this->post('/admin/users', [
            'name' => 'Budi Editor Humas',
            'email' => 'budi.editor@sman24bdg.sch.id',
            'password' => 'Password24!',
            'password_confirmation' => 'Password24!',
            'role' => 'editor',
            'is_active' => 1,
        ]);
        $createUser->assertRedirect(route('admin.users.index'));
        $this->assertDatabaseHas('users', ['email' => 'budi.editor@sman24bdg.sch.id', 'role' => 'editor']);

        $editorUser = User::where('email', 'budi.editor@sman24bdg.sch.id')->first();

        // Edit & Update User
        $updateUser = $this->put("/admin/users/{$editorUser->id}", [
            'name' => 'Budi Utama M.Pd.',
            'email' => 'budi.editor@sman24bdg.sch.id',
            'role' => 'admin',
            'is_active' => 1,
        ]);
        $updateUser->assertRedirect(route('admin.users.index'));
        $this->assertDatabaseHas('users', ['name' => 'Budi Utama M.Pd.', 'role' => 'admin']);

        // Prevent self deletion
        $selfDelete = $this->delete("/admin/users/{$superadmin->id}");
        $selfDelete->assertRedirect(route('admin.users.index'));
        $this->assertDatabaseHas('users', ['id' => $superadmin->id]);

        // Search & Filter Users
        $searchUser = $this->get('/admin/users?search=Budi&role=admin');
        $searchUser->assertStatus(200);
        $searchUser->assertSee('Budi Utama M.Pd.');

        // 3. Bulk Action Delete for Users
        $user1 = User::create(['name' => 'User 1', 'email' => 'u1@sman24.sch.id', 'password' => Hash::make('secret'), 'role' => 'editor']);
        $user2 = User::create(['name' => 'User 2', 'email' => 'u2@sman24.sch.id', 'password' => Hash::make('secret'), 'role' => 'guru']);

        $bulkDeleteUsers = $this->post('/admin/users/bulk-delete', [
            'ids' => [$user1->id, $user2->id],
        ]);
        $bulkDeleteUsers->assertRedirect(route('admin.users.index'));
        $this->assertDatabaseMissing('users', ['id' => $user1->id]);
        $this->assertDatabaseMissing('users', ['id' => $user2->id]);

        // 4. Bulk Delete for Teachers
        $t1 = Teacher::create(['name' => 'Guru A', 'subject' => 'Fisika', 'gender' => 'L', 'is_active' => true]);
        $t2 = Teacher::create(['name' => 'Guru B', 'subject' => 'Kimia', 'gender' => 'P', 'is_active' => true]);

        $bulkDeleteTeachers = $this->post('/admin/teachers/bulk-delete', [
            'ids' => [$t1->id, $t2->id],
        ]);
        $bulkDeleteTeachers->assertRedirect(route('admin.teachers.index'));
        $this->assertDatabaseMissing('teachers', ['id' => $t1->id]);
        $this->assertDatabaseMissing('teachers', ['id' => $t2->id]);
    }
}
