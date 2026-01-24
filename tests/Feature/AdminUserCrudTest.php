<?php

namespace Tests\Feature;

use App\Models\Admin;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Illuminate\Support\Facades\Hash;

class AdminUserCrudTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        // create an admin
        Admin::create(['nama' => 'admin', 'email' => 'admin@example.com', 'password' => Hash::make('secret')]);
    }

    public function test_admin_can_create_update_and_delete_user()
    {
        $admin = Admin::first();
        $this->actingAs($admin, 'admin');

        // create user
        $resp = $this->post('/admin/customers', [
            'name' => 'New User',
            'email' => 'newuser@example.com',
            'password' => 'secret123',
            'password_confirmation' => 'secret123',
        ]);
        $resp->assertRedirect(route('admin.customers'));
        $this->assertDatabaseHas('users', ['email' => 'newuser@example.com']);

        $user = User::where('email', 'newuser@example.com')->first();

        // update
        $resp = $this->put('/admin/customers/'.$user->id, [
            'name' => 'Updated Name',
            'email' => 'newuser@example.com',
            'password' => '',
            'password_confirmation' => '',
        ]);
        $resp->assertRedirect(route('admin.customers'));
        $this->assertDatabaseHas('users', ['email' => 'newuser@example.com', 'name' => 'Updated Name']);

        // delete
        $resp = $this->delete('/admin/customers/'.$user->id);
        $resp->assertRedirect(route('admin.customers'));
        $this->assertDatabaseMissing('users', ['email' => 'newuser@example.com']);
    }
}
