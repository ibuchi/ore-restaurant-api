<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test the index method.
     *
     * @return void
     */
    public function test_index_returns_all_users()
    {
        $staff = User::factory()->create(['type' => 'staff']);

        $response = $this->actingAs($staff)->getJson('/api/v1/users');

        $response->assertStatus(200);
    }

    /**
     * Test the show method.
     *
     * @return void
     */
    public function test_show_returns_a_specific_user()
    {
        $user = User::factory()->create();
        $staff = User::factory()->create(['type' => 'staff']);

        $response = $this->actingAs($staff)->getJson("/api/v1/users/{$user->id}");

        $response->assertStatus(200);
    }

    /**
     * Test unauthorized access to the index method.
     *
     * @return void
     */
    public function test_unauthorized_index_access()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->getJson('/api/v1/users');

        $response->assertStatus(403);
    }

    /**
     * Test unauthorized access to the show method.
     *
     * @return void
     */
    public function test_unauthorized_show_access()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->getJson("/api/v1/users/{$user->id}");

        $response->assertStatus(403);
    }
}
