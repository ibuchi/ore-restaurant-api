<?php

namespace Tests\Feature;

use App\Models\Menu;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class MenuTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test listing all menus.
     */
    public function test_can_list_all_menus(): void
    {
        $user = User::factory()->create();
        $menus = Menu::factory()->count(3)->create();

        $response = $this->actingAs($user)->getJson('/api/v1/menus');

        $response->assertStatus(200)
            ->assertJson([
                'message' => 'All menus!',
                'data' => $menus->toArray()
            ]);
    }

    /**
     * Test creating a new menu item.
     */
    public function test_can_create_menu(): void
    {
        $user = User::factory()->create(['type' => 'staff']);
        $menuData = Menu::factory()->make()->toArray();

        $response = $this->actingAs($user)->postJson('/api/v1/menus', $menuData);

        $response->assertStatus(200)
            ->assertJson([
                'message' => 'Menu added!',
                'data' => $menuData
            ]);

        $this->assertDatabaseHas('menus', $menuData);
    }

    /**
     * Test showing a specific menu item.
     */
    public function test_can_show_menu(): void
    {
        $user = User::factory()->create();
        $menu = Menu::factory()->create();

        $response = $this->actingAs($user)->getJson("/api/v1/menus/{$menu->id}");

        $response->assertStatus(200)
            ->assertJson([
                'message' => 'Menu!',
                'data' => $menu->toArray()
            ]);
    }

    /**
     * Test updating a menu item.
     */
    public function test_can_update_menu(): void
    {
        $user = User::factory()->create(['type' => 'staff']);
        $menu = Menu::factory()->create();
        $menuData = Menu::factory()->make()->toArray();

        $response = $this->actingAs($user)->putJson("/api/v1/menus/{$menu->id}", $menuData);

        $response->assertStatus(200)
            ->assertJson([
                'message' => 'Menu updated!',
                'data' => $menuData
            ]);

        $this->assertDatabaseHas('menus', $menuData);
    }

    /**
     * Test deleting a menu item.
     */
    public function test_can_delete_menu(): void
    {
        $user = User::factory()->create(['type' => 'staff']);
        $menu = Menu::factory()->create();

        $response = $this->actingAs($user)->deleteJson("/api/v1/menus/{$menu->id}");

        $response->assertStatus(200);

        $this->assertDatabaseMissing('menus', $menu->toArray());
    }

    /**
     * Test listing discounted menus.
     */
    public function test_can_list_discounted_menus(): void
    {
        $user = User::factory()->create();
        $discountedMenus = Menu::factory()->count(3)->create([
            'is_discounted' => 1
        ]);

        $response = $this->actingAs($user)->getJson('/api/v1/menus/discounted');

        $response->assertStatus(200)
            ->assertJson([
                'message' => 'Discounted Menus!',
            ]);
    }

    /**
     * Test listing drink menus.
     */
    public function test_can_list_drink_menus(): void
    {
        $user = User::factory()->create();
        $drinkMenus = Menu::factory()->count(3)->create(['category' => 'drink']);

        $response = $this->actingAs($user)->getJson('/api/v1/menus/drinks');

        $response->assertStatus(200)
            ->assertJson([
                'message' => 'Drinks on the menu!',
                'data' => $drinkMenus->toArray()
            ]);
    }
}
