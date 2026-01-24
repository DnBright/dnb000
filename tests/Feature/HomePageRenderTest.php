<?php

namespace Tests\Feature;

use App\Models\Page;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HomePageRenderTest extends TestCase
{
    use RefreshDatabase;

    public function test_homepage_renders_dynamic_content()
    {
        Page::create(['key' => 'home', 'content' => ['hero_title' => 'Dynamic Title']]);

        $resp = $this->get('/');
        $resp->assertStatus(200);
        $resp->assertSee('Dynamic Title');
    }

    public function test_homepage_includes_search_featured_items()
    {
        Page::create(['key' => 'search', 'content' => ['featured_items' => [['title' => 'Logo Design','image' => '/storage/pages/sample.jpg']]]]);

        $resp = $this->get('/');
        $resp->assertStatus(200);
        $resp->assertSee('Logo Design');
        $resp->assertSee('/storage/pages/sample.jpg');
    }

    public function test_homepage_shows_six_popular_services()
    {
        $services = [];
        for ($i=1;$i<=6;$i++) {
            $services[] = ['title' => 'Svc '.$i, 'subtitle' => 'S'.$i, 'image' => '/storage/pages/svc'.$i.'.jpg'];
        }
        Page::create(['key' => 'home', 'content' => ['services' => $services]]);

        $resp = $this->get('/');
        $resp->assertStatus(200);
        foreach ($services as $s) {
            $resp->assertSee($s['title']);
            $resp->assertSee($s['image']);
        }
    }

    public function test_homepage_renders_top_designers()
    {
        $designers = [];
        for ($i=1;$i<=4;$i++) {
            $designers[] = ['name' => 'D '.$i, 'role' => 'R'.$i, 'image' => '/storage/pages/d'.$i.'.jpg'];
        }
        Page::create(['key' => 'home', 'content' => ['top_designers' => $designers]]);

        $resp = $this->get('/');
        $resp->assertStatus(200);
        foreach ($designers as $d) {
            $resp->assertSee($d['name']);
            $resp->assertSee($d['image']);
        }
    }

    public function test_homepage_renders_reviews()
    {
        $reviews = [
            ['message'=>'Amazing work!','author'=>'Client A','rating'=>5,'image'=>'/storage/pages/r1.jpg'],
            ['message'=>'Very professional.','author'=>'Client B','rating'=>4,'image'=>'/storage/pages/r2.jpg'],
        ];
        Page::create(['key' => 'home', 'content' => ['reviews' => $reviews]]);

        $resp = $this->get('/');
        $resp->assertStatus(200);
        $resp->assertSee('Amazing work!');
        $resp->assertSee('/storage/pages/r1.jpg');
    }
}
