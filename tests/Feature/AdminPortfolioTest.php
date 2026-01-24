<?php

namespace Tests\Feature;

use App\Models\Admin;
use App\Models\Page;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AdminPortfolioTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        Admin::create(['nama' => 'admin', 'email' => 'admin@example.com', 'password' => Hash::make('secret')]);
    }

    public function test_admin_can_update_logo_portfolio()
    {
        Storage::fake('public');
        $admin = Admin::first();
        $this->actingAs($admin, 'admin');

        $file = UploadedFile::fake()->image('logo.jpg');

        $data = [
            'logo_titles' => ['L1','L2','L3'],
            'logo_captions' => ['c1','c2','c3'],
            'logo_links' => ['#','#','#'],
        ];

        $resp = $this->followingRedirects()->put('/admin/portfolio/logo', $data + ['logo_images' => [$file]]);
        $resp->assertStatus(200);

        $page = Page::where('key','portfolio')->first();
        $this->assertArrayHasKey('logo', $page->content);
        $this->assertCount(3, $page->content['logo']);
        $this->assertEquals('L1', $page->content['logo'][0]['title']);
        $this->assertStringContainsString('storage/pages', $page->content['logo'][0]['image']);
    }

    public function test_admin_can_update_stationery_portfolio()
    {
        Storage::fake('public');
        $admin = Admin::first();
        $this->actingAs($admin, 'admin');

        $file = UploadedFile::fake()->image('st.jpg');
        $data = [
            'stationery_titles' => ['S1','S2','S3'],
            'stationery_captions' => ['c1','c2','c3'],
            'stationery_links' => ['#','#','#'],
        ];

        $resp = $this->followingRedirects()->put('/admin/portfolio/stationery', $data + ['stationery_images' => [$file]]);
        $resp->assertStatus(200);

        $page = Page::where('key','portfolio')->first();
        $this->assertArrayHasKey('stationery', $page->content);
        $this->assertCount(3, $page->content['stationery']);
        $this->assertEquals('S1', $page->content['stationery'][0]['title']);
    }
}
