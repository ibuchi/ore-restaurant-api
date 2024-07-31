<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Menu>
 */
class MenuFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = [
            'Pizza',
            'Burger',
            'Pasta',
            'Sushi',
            'Tacos',
            'Salad',
            'Sandwich',
            'Steak',
            'Soup',
            'Curry',
        ];

        shuffle($name);

        $categories = [
            'Drinks',
            'Main Course',
            'Desserts',
            'Beverages',
            'Drinks',
            'Salads',
            'Soups',
            'Snacks',
            'Breads',
            'Pasta',
            'Seafood',
        ];

        shuffle($categories);

        return [
            'name' => $name[0],
            'description' => "A delicious {$name[0]} with all the fixings.",
            'category' => $categories[0],
            'price' => random_int( 500, 5000),
            'is_discounted' => random_int(0, 1)
        ];
    }
}
