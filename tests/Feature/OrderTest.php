<?php

namespace Tests\Feature;

use App\Models\Order;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Tests\TestCase;

class OrderTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test listing all orders.
     *
     * @return void
     */
    public function test_can_list_all()
    {
        $user = User::factory()->create();
        $orders = Order::factory()->count(3)->create();

        // Act: Make a request to the index endpoint
        $response = $this->actingAs($user)->getJson('/api/v1/orders');

        // Assert: Check the response
        $response->assertStatus(Response::HTTP_OK)
            ->assertJson([
                'message' => 'All orders!',
                'data' => $orders->toArray(),
            ]);
    }

    /**
     * Test storing a new order.
     *
     * @return void
     */
    public function test_can_create_an_order()
    {
        $user = User::factory()->create();

        $orderData = [
            'email' => 'ibuchibasil@gmail.com',
            'phone' => '2349037426727',
            'address' => 'No. 16 Akinpelu Close, Iyanaoworo, Lagos',
            'product_id' => 1,
            'quantity' => 2,
            'total_price' => 100.00,
            'menus' =>  [
                "1" =>  [
                    "quantity" =>  2
                ],
                "3" => [
                    "quantity" => 1

                ]
            ]
        ];

        // Act: Make a request to store a new order
        $response = $this->actingAs($user)->postJson('/api/v1/orders', $orderData);

        // Assert: Check the response
        $response->assertStatus(Response::HTTP_OK)
            ->assertJson([
                'status' => true,
                'message' => 'Order placed!',
            ]);
    }
}
