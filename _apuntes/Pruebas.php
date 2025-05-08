<?

// tests/Unit/OrderTest.php
namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Order;
use App\Models\Photo;

class OrderTest extends TestCase
{
    public function test_order_total_price_is_correct()
    {
        $order = Order::factory()->create();
        $photo1 = Photo::factory()->create(['price' => 10]);
        $photo2 = Photo::factory()->create(['price' => 15]);

        $order->photos()->attach([$photo1->id, $photo2->id]);

        $this->assertEquals(25, $order->totalPrice());
    }