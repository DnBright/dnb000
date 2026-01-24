<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BriefFlowTest extends TestCase
{
    use RefreshDatabase;

    public function test_brief_submission_redirects_to_review_and_sets_session()
    {
        $resp = $this->post('/brief/review', [
            'paket' => 'logo-design',
            'nama' => 'Acme',
            'email' => 'me@example.com',
            'whatsapp' => '081234567890',
            'brand' => 'Acme Inc',
            'jenis_usaha' => 'Retail'
        ]);

        $resp->assertRedirect(route('review.show'));

        // Follow redirect and assert review page shows submitted data
        $follow = $this->get(route('review.show'));
        $follow->assertStatus(200);
        $follow->assertSee('Acme');
        $follow->assertSee('me@example.com');
    }
}
