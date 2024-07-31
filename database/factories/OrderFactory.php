<?php

namespace Database\Factories;

use App\Models\Menu;
use App\Models\Order;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::inRandomOrder()->first()->id,
            'email' => fake()->safeEmail(),
            'phone' => fake()->phoneNumber(),
            'address' => fake()->address(),
            'total_price' => 0,
            'quantity' => 0
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function (Order $order) {
            $menus = Menu::inRandomOrder()->take(rand(1, 5))->get();
            $totalPrice = 0;
            $quantity = 0;

            foreach ($menus as $menu) {
                $qty = rand(1, 3); // Random quantity
                $price = random_int(300, 5000);
                $order->menus()->attach($menu->id, ['quantity' => $qty, 'price' => $price]);
                $totalPrice += $menu->price * $qty;
                $quantity += $qty;
            }

            $order->update([
                'total_price' => $totalPrice,
                'quantity' => $quantity,
            ]);
        });
    }
}
