<?php

namespace Tests\Feature;

use App\Models\Admin;
use App\Models\Page;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;

class AdminPagesTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        Admin::create(['nama' => 'admin', 'email' => 'admin@example.com', 'password' => Hash::make('secret')]);
    }

    public function test_admin_can_view_home_edit_form()
    {
        $admin = Admin::first();
        $this->actingAs($admin, 'admin');

        $resp = $this->get('/admin/pages/home');
        $resp->assertStatus(200);
        $resp->assertSee('Edit Halaman Utama');
    }

    public function test_admin_can_update_home_content()
    {
        $admin = Admin::first();
        $this->actingAs($admin, 'admin');

        $resp = $this->put('/admin/pages/home', [
            'hero_title' => 'New Hero',
            'hero_subtitle' => 'Subtitle here',
            'cta1_label' => 'Start',
            'cta1_link' => 'https://example.com',
        ]);

        $resp->assertRedirect(route('admin.pages.home.edit'));
        $this->assertDatabaseHas('pages', ['key' => 'home']);
        $page = Page::where('key', 'home')->first();
        $this->assertEquals('New Hero', $page->content['hero_title']);
    }

    public function test_admin_can_save_placeholder_links()
    {
        $admin = Admin::first();
        $this->actingAs($admin, 'admin');

        $resp = $this->put('/admin/pages/home', [
            'hero_title' => 'With Hash',
            'cta1_label' => 'Start',
            'cta1_link' => '#',
            'cta2_link' => '#',
        ]);

        $resp->assertRedirect(route('admin.pages.home.edit'));
        $page = Page::where('key', 'home')->first();
        $this->assertEquals('#', $page->content['cta1_link']);
    }

    public function test_admin_can_upload_hero_image()
    {
        Storage::fake('public');

        $admin = Admin::first();
        $this->actingAs($admin, 'admin');

        $file = UploadedFile::fake()->image('hero.jpg');

        $resp = $this->followingRedirects()->put('/admin/pages/home', [
            'hero_title' => 'Image Test',
            'hero_image' => $file,
        ]);

        $resp->assertStatus(200);

        $page = Page::where('key', 'home')->first();
        $this->assertStringContainsString('storage/pages', $page->content['hero_image']);
        // Assert file exists in the fake disk
        Storage::disk('public')->assertExists(str_replace('/storage/','',$page->content['hero_image']));
    }

    public function test_admin_can_remove_hero_image()
    {
        Storage::fake('public');

        // create a fake existing file
        $path = 'pages/existing.jpg';
        Storage::disk('public')->put($path, 'contents');

        $page = Page::updateOrCreate(['key' => 'home'], ['content' => ['hero_image' => '/storage/'.$path]]);

        $admin = Admin::first();
        $this->actingAs($admin, 'admin');

        $resp = $this->followingRedirects()->put('/admin/pages/home', [
            'hero_title' => 'Remove Test',
            'remove_hero_image' => '1',
        ]);

        $resp->assertStatus(200);
        $page = Page::where('key','home')->first();
        $this->assertArrayNotHasKey('hero_image', $page->content);
        Storage::disk('public')->assertMissing($path);
    }


    public function test_admin_can_view_services_edit_form()
    {
        $admin = Admin::first();
        $this->actingAs($admin, 'admin');

        $resp = $this->get('/admin/pages/services');
        $resp->assertStatus(200);
        $resp->assertSee('Jasa Design Terpopuler');
    }

    public function test_admin_can_update_services_via_services_route()
    {
        Storage::fake('public');

        $admin = Admin::first();
        $this->actingAs($admin, 'admin');

        $file = UploadedFile::fake()->image('svc.jpg');

        $data = [
            'service_titles' => ['A','B','C','D','E','F'],
            'service_subtitles' => ['a','b','c','d','e','f'],
        ];

        $resp = $this->followingRedirects()->put('/admin/pages/services', $data + ['service_images' => [$file]]);
        $resp->assertStatus(200);

        $page = Page::where('key','home')->first();
        $this->assertCount(6, $page->content['services']);
        $this->assertEquals('A', $page->content['services'][0]['title']);
        $this->assertStringContainsString('storage/pages', $page->content['services'][0]['image']);
    }

    public function test_admin_can_view_top_designers_edit_form()
    {
        $admin = Admin::first();
        $this->actingAs($admin, 'admin');

        $resp = $this->get('/admin/pages/top-designers');
        $resp->assertStatus(200);
        $resp->assertSee('Designer Terbaik');
    }

    public function test_admin_can_update_top_designers()
    {
        Storage::fake('public');

        $admin = Admin::first();
        $this->actingAs($admin, 'admin');

        $file = UploadedFile::fake()->image('d.jpg');

        $data = [
            'designer_names' => ['A','B','C','D'],
            'designer_roles' => ['a','b','c','d'],
        ];

        $resp = $this->followingRedirects()->put('/admin/pages/top-designers', $data + ['designer_images' => [$file]]);
        $resp->assertStatus(200);

        $page = Page::where('key','home')->first();
        $this->assertArrayHasKey('top_designers', $page->content);
        $this->assertCount(4, $page->content['top_designers']);
        $this->assertEquals('A', $page->content['top_designers'][0]['name']);
        $this->assertStringContainsString('storage/pages', $page->content['top_designers'][0]['image']);
    }

    public function test_admin_can_view_templates_edit_form()
    {
        $admin = Admin::first();
        $this->actingAs($admin, 'admin');

        $resp = $this->get('/admin/pages/templates');
        $resp->assertStatus(200);
        $resp->assertSee('Template');
    }

    public function test_admin_can_view_review_edit_form()
    {
        $admin = Admin::first();
        $this->actingAs($admin, 'admin');

        $resp = $this->get('/admin/pages/review');
        $resp->assertStatus(200);
        $resp->assertSee('Review');
    }

    public function test_admin_can_view_layanan_edit_form()
    {
        $admin = Admin::first();
        $this->actingAs($admin, 'admin');

        $resp = $this->get('/admin/pages/layanan');
        $resp->assertStatus(200);
        $resp->assertSee('Layanan');
    }

    public function test_admin_can_update_layanan()
    {
        Storage::fake('public');

        $admin = Admin::first();
        $this->actingAs($admin, 'admin');

        $file = UploadedFile::fake()->image('svc.jpg');

        $data = [
            'layanan_titles' => ['A','B','C','D','E','F'],
            'layanan_subtitles' => ['a','b','c','d','e','f'],
        ];

        $resp = $this->followingRedirects()->put('/admin/pages/layanan', $data + ['layanan_images' => [$file]]);
        $resp->assertStatus(200);

        $page = Page::where('key','layanan')->first();
        $this->assertCount(6, $page->content['services']);
        $this->assertEquals('A', $page->content['services'][0]['title']);
        $this->assertStringContainsString('storage/pages', $page->content['services'][0]['image']);
        $this->assertArrayHasKey('paket', $page->content['services'][0]);
        $this->assertEquals('a', $page->content['services'][0]['paket']);
    }

    public function test_admin_can_remove_layanan_image()
    {
        Storage::fake('public');

        $path = 'pages/existing_svc.jpg';
        Storage::disk('public')->put($path, 'contents');

        $page = Page::updateOrCreate(['key' => 'layanan'], ['content' => ['services' => [['title'=>'X','subtitle'=>'Y','image'=>'/storage/'.$path]]]]);

        $admin = Admin::first();
        $this->actingAs($admin, 'admin');

        $resp = $this->followingRedirects()->put('/admin/pages/layanan', [
            'layanan_titles' => ['X','','','','',''],
            'layanan_subtitles' => ['Y','','','','',''],
            'remove_layanan_0' => '1'
        ]);

        $resp->assertStatus(200);
        $page = Page::where('key','layanan')->first();
        $this->assertArrayNotHasKey('image', $page->content['services'][0] ?? []);
        Storage::disk('public')->assertMissing($path);
    }

    public function test_admin_can_update_reviews()
    {
        Storage::fake('public');

        $admin = Admin::first();
        $this->actingAs($admin, 'admin');

        $file = UploadedFile::fake()->image('rev1.jpg');

        $data = [
            'review_messages' => ['Great service','','','','',''],
            'review_authors' => ['Client','','','','',''],
            'review_ratings' => [5,4,3,2,1,5],
        ];

        $resp = $this->followingRedirects()->put('/admin/pages/review', $data + ['review_images' => [$file]]);
        $resp->assertStatus(200);

        $page = Page::where('key','home')->first();
        $this->assertArrayHasKey('reviews', $page->content);
        $this->assertEquals('Great service', $page->content['reviews'][0]['message']);
        $this->assertEquals('Client', $page->content['reviews'][0]['author']);
        $this->assertStringContainsString('storage/pages', $page->content['reviews'][0]['image']);
    }

    public function test_admin_can_remove_review_image()
    {
        Storage::fake('public');

        $path = 'pages/existing_rev.jpg';
        Storage::disk('public')->put($path, 'contents');

        $page = Page::updateOrCreate(['key' => 'home'], ['content' => ['reviews' => [['message'=>'X','author'=>'Y','rating'=>5,'image'=>'/storage/'.$path]]]]);

        $admin = Admin::first();
        $this->actingAs($admin, 'admin');

        $resp = $this->followingRedirects()->put('/admin/pages/review', [
            'review_messages' => ['X','','','','',''],
            'review_authors' => ['Y','','','','',''],
            'review_ratings' => [5,4,3,2,1,5],
            'remove_review_0' => '1'
        ]);

        $resp->assertStatus(200);
        $page = Page::where('key','home')->first();
        $this->assertArrayNotHasKey('image', $page->content['reviews'][0] ?? []);
        Storage::disk('public')->assertMissing($path);
    }

    public function test_admin_can_update_templates()
    {
        Storage::fake('public');

        $admin = Admin::first();
        $this->actingAs($admin, 'admin');

        $file = UploadedFile::fake()->image('tpl.jpg');

        $data = [
            'template_names' => ['T1','T2','T3','T4'],
            'template_prices' => ['P1','P2','P3','P4'],
            'template_links' => ['#','#','#','#'],
        ];

        $resp = $this->followingRedirects()->put('/admin/pages/templates', $data + ['template_images' => [$file]]);
        $resp->assertStatus(200);

        $page = Page::where('key','home')->first();
        $this->assertArrayHasKey('templates', $page->content);
        $this->assertCount(4, $page->content['templates']);
        $this->assertEquals('T1', $page->content['templates'][0]['name']);
        $this->assertStringContainsString('storage/pages', $page->content['templates'][0]['image']);
    }
}
