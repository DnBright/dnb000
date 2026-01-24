<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Order;

class OrderFlowTest extends TestCase
{
    use RefreshDatabase;

    public function test_payment_endpoint_creates_order_and_shows_payment_page()
    {
        // Simulate that review data is already in session
        $this->withSession([
            'reviewData' => ['nama' => 'Acme', 'email' => 'a@b.com', 'jenis_usaha' => 'Retail'],
            'selectedPaket' => 'logo-design'
        ]);

        $resp = $this->post('/payment');
        $resp->assertRedirect();

        $order = Order::first();
        $this->assertNotNull($order);
        $this->assertEquals('logo-design', $order->service);

        $show = $this->get('/payment/' . $order->id);
        $show->assertStatus(200);
        $show->assertSee('Invoice Order #' . $order->id);
        $show->assertSee('Logo Design');
        // WA link to admin should be present and include the order id
        $show->assertSee('https://wa.me/6285158661152');
        $show->assertSee('#' . $order->id);
    }
}
