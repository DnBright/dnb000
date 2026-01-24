<?php

namespace Tests\Feature;

use App\Models\Admin;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Illuminate\Support\Facades\Hash;

class AdminAuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_is_redirected_to_admin_login()
    {
        $response = $this->get('/admin/dashboard');
        $response->assertRedirect(route('admin.login'));
    }

    public function test_admin_can_login_and_access_dashboard()
    {
        $admin = Admin::create([
            'nama' => 'test admin',
            'email' => 'testadmin@example.com',
            'password' => Hash::make('secret123'),
        ]);

        $response = $this->post('/admin/login', [
            'email' => 'testadmin@example.com',
            'password' => 'secret123',
        ]);

        $response->assertRedirect(route('admin.dashboard'));

        // follow redirect
        $this->followingRedirects()
            ->get(route('admin.dashboard'))
            ->assertStatus(200);
    }

    public function test_admin_can_logout()
    {
        $admin = Admin::create([
            'nama' => 'test admin',
            'email' => 'testadmin2@example.com',
            'password' => Hash::make('secret123'),
        ]);

        // login
        $this->post('/admin/login', ['email' => 'testadmin2@example.com', 'password' => 'secret123']);

        // logout
        $this->post('/admin/logout')->assertRedirect(route('admin.login'));

        // after logout, dashboard should redirect to login
        $this->get('/admin/dashboard')->assertRedirect(route('admin.login'));
    }
}
