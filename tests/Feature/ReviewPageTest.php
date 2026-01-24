<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ReviewPageTest extends TestCase
{
    use RefreshDatabase;

    public function test_review_page_shows_single_concept_and_confirm_button()
    {
        $this->withSession([
            'reviewData' => ['nama' => 'Acme', 'email' => 'a@b.com', 'paket' => 'logo-design'],
            'selectedPaket' => 'logo-design'
        ]);

        $resp = $this->get('/review');
        $resp->assertStatus(200);
        $resp->assertSee('Konsep 1');
        $resp->assertSee('Konsep desain awal');
        $resp->assertSee(route('brief.show', ['paket' => 'logo-design']));
        $resp->assertSee(route('payment.process'));
        $resp->assertSee('Konfirmasi');
        $resp->assertSee('Bayar');
    }
}
