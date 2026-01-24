<?php

namespace Tests\Feature;

use App\Models\Admin;
use App\Models\Page;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class AdminSearchPageTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        Admin::create(['nama' => 'admin', 'email' => 'admin@example.com', 'password' => Hash::make('secret')]);
    }

    public function test_admin_can_view_search_edit_form()
    {
        $admin = Admin::first();
        $this->actingAs($admin, 'admin');

        $resp = $this->get('/admin/pages/search');
        $resp->assertStatus(200);
        $resp->assertSee('Edit Pencarian Pelayanan');
    }

    public function test_admin_can_update_search_page()
    {
        $admin = Admin::first();
        $this->actingAs($admin, 'admin');

        $resp = $this->put('/admin/pages/search', [
            'search_placeholder' => 'Test placeholder',
            'intro_text' => 'Some intro',
            'featured_categories' => 'A,B,C',
        ]);

        $resp->assertRedirect(route('admin.pages.search.edit'));
        $this->assertDatabaseHas('pages', ['key' => 'search']);
        $page = Page::where('key','search')->first();
        $this->assertEquals('Test placeholder', $page->content['search_placeholder']);
    }

    public function test_admin_can_update_search_with_featured_items_and_images()
    {
        Storage::fake('public');

        $admin = Admin::first();
        $this->actingAs($admin, 'admin');

        $file = \Illuminate\Http\UploadedFile::fake()->image('svc.jpg');

        $resp = $this->post('/admin/pages/search', [
            '_method' => 'PUT',
            'search_placeholder' => 'Test',
            'featured_titles' => ['Logo Design'],
        ] + ['featured_images' => [$file]]);

        $resp->assertRedirect();
        $page = Page::where('key','search')->first();
        $this->assertNotEmpty($page->content['featured_items']);
        $this->assertEquals('Logo Design', $page->content['featured_items'][0]['title']);
        $this->assertStringContainsString('storage/pages', $page->content['featured_items'][0]['image']);
    }
}
