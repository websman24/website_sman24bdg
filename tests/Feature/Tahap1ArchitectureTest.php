<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class Tahap1ArchitectureTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test public homepage loads successfully and contains school details.
     */
    public function test_public_homepage_renders_successfully(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('SMA Negeri 24 Bandung');
        $response->assertSee('Jl. A.H. Nasution No. 27, Kota Bandung');
    }

    /**
     * Test admin login page displays form.
     */
    public function test_admin_login_page_renders_successfully(): void
    {
        $response = $this->get('/admin/login');

        $response->assertStatus(200);
        $response->assertSee('Portal Masuk Administrator');
    }

    /**
     * Test unauthorized access to admin dashboard redirects to admin login.
     */
    public function test_guest_cannot_access_admin_dashboard(): void
    {
        $response = $this->get('/admin');

        $response->assertRedirect('/admin/login');
    }

    /**
     * Test administrator authentication and dashboard access.
     */
    public function test_administrator_can_login_and_access_dashboard(): void
    {
        $admin = User::create([
            'name' => 'Administrator SMAN 24',
            'email' => 'admin@sman24bdg.sch.id',
            'password' => Hash::make('Password24!'),
            'role' => 'admin',
        ]);

        $response = $this->post('/admin/login', [
            'email' => 'admin@sman24bdg.sch.id',
            'password' => 'Password24!',
        ]);

        $response->assertRedirect(route('admin.dashboard'));
        $this->assertAuthenticatedAs($admin);

        $dashboardResponse = $this->get('/admin');
        $dashboardResponse->assertStatus(200);
        $dashboardResponse->assertSee('Selamat Datang');
        $dashboardResponse->assertSee('SMA Negeri 24 Bandung');
    }

    /**
     * Test logout action clears authentication session.
     */
    public function test_administrator_can_logout(): void
    {
        $admin = User::create([
            'name' => 'Administrator SMAN 24',
            'email' => 'admin@sman24bdg.sch.id',
            'password' => Hash::make('Password24!'),
            'role' => 'admin',
        ]);

        $this->actingAs($admin);

        $response = $this->post('/admin/logout');

        $response->assertRedirect(route('home'));
        $this->assertGuest();
    }
}
