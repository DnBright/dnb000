<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PortfolioPageTest extends TestCase
{
    use RefreshDatabase;

    public function test_portfolio_page_shows_categories()
    {
        $resp = $this->get('/portfolio');
        $resp->assertStatus(200);
        $resp->assertSee('Logo');
        $resp->assertSee('Design Stationery');
        $resp->assertSee('Website Design');
        $resp->assertSee('Kemasan Design');
        $resp->assertSee('Feeds Design');
        $resp->assertSee('Design Lainnya');
    }

    public function test_portfolio_page_renders_seeded_items()
    {
        // Seeder runs in DatabaseSeeder normally; we can create the page directly here
        $this->seed(\Database\Seeders\HomePageSeeder::class);

        $resp = $this->get('/portfolio');
        $resp->assertStatus(200);
        $resp->assertSee('Stationery Set 1');
        $resp->assertSee('Landing 1');
        $resp->assertSee('Packaging 1');
        $resp->assertSee('Feed Pack 1');
        $resp->assertSee('Poster 1');
    }

    public function test_paket_page_renders_layanan_from_pages()
    {
        $services = [
            ['title'=>'X1','subtitle'=>'S1','image'=>'/storage/pages/x1.jpg','paket'=>'x1'],
            ['title'=>'X2','subtitle'=>'S2','image'=>'/storage/pages/x2.jpg','paket'=>'x2'],
            ['title'=>'X3','subtitle'=>'S3','image'=>'/storage/pages/x3.jpg','paket'=>'x3'],
            ['title'=>'X4','subtitle'=>'S4','image'=>'/storage/pages/x4.jpg','paket'=>'x4'],
            ['title'=>'X5','subtitle'=>'S5','image'=>'/storage/pages/x5.jpg','paket'=>'x5'],
            ['title'=>'X6','subtitle'=>'S6','image'=>'/storage/pages/x6.jpg','paket'=>'x6'],
        ];

        $page = \App\Models\Page::updateOrCreate(['key' => 'layanan'], ['content' => ['services' => $services]]);

        $resp = $this->get('/paket');
        $resp->assertStatus(200);
        $resp->assertSee('X1');
        $resp->assertSee('S1');
        $resp->assertSee('/storage/pages/x1.jpg');
        $resp->assertSee('chooseService');
    }

    public function test_paket_page_handles_service_with_missing_paket_gracefully()
    {
        $page = \App\Models\Page::updateOrCreate(['key' => 'layanan'], ['content' => ['services' => [
            ['title'=>'NoLink','subtitle'=>'Sx','image'=>'/storage/pages/nolink.jpg']
        ]] ]);

        $resp = $this->get('/paket');
        $resp->assertStatus(200);
        $resp->assertSee('NoLink');
        // link should now point to generated slug 'nolink'
        $resp->assertSee(route('brief.show', ['paket' => 'nolink']));
        $resp->assertSee('Pilih Layanan');
    }

    public function test_paket_link_goes_directly_to_brief()
    {
        $page = \App\Models\Page::updateOrCreate(['key' => 'layanan'], ['content' => ['services' => [
            ['title'=>'Logo','subtitle'=>'desc','image'=>'/storage/pages/logo.jpg','paket'=>'logo-design']
        ]] ]);

        $resp = $this->get('/paket');
        $resp->assertStatus(200);
        $resp->assertSee(route('brief.show', ['paket' => 'logo-design']));

        $brief = $this->get('/brief/logo-design');
        $brief->assertStatus(200);
        $brief->assertSee('Logo Design Brief');
    }
}
