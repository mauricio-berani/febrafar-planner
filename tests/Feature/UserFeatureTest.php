<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserFeatureTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create([
            'name' => 'Tester',
            'role' => 'administrator'
        ]);
    }

    public function test_can_retrieve_all_users()
    {
        $response = $this->actingAs($this->user)->getJson(route('users.findAll'));
        $response->assertOk();
    }

    public function test_can_retrieve_matched_users()
    {
        $data = ['search' => 'John Doe'];
        $response = $this->actingAs($this->user)->getJson(route('users.findAllMatches', $data));
        $response->assertOk();
    }

    public function test_can_retrieve_single_user()
    {
        $response = $this->actingAs($this->user)->getJson(route('users.findOne', ['user' => $this->user->id]));
        $response->assertOk();
    }

    public function test_can_create_user()
    {
        $data = [
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'password' => 'password',
            'role' => 'user',
        ];
        $response = $this->actingAs($this->user)->postJson(route('users.create'), $data);
        $response->assertCreated();
    }

    public function test_can_update_user()
    {
        $data = ['name' => $this->faker->name];
        $response = $this->actingAs($this->user)->putJson(route('users.update', ['user' => $this->user->id]), $data);
        $response->assertOk();
    }

    public function test_can_delete_user()
    {
        $response = $this->actingAs($this->user)->deleteJson(route('users.delete', ['user' => $this->user->id]));
        $response->assertNoContent();
    }
}
