<?php

namespace Tests\Feature;

use App\Models\Task\Type;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TypeFeatureTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_retrieve_matching_types()
    {
        $user = User::factory()->create();
        Type::factory()->count(5)->create();
        $response = $this->actingAs($user)->getJson('/api/task_types/match');
        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    'items' => [
                        '*' => [
                            'id',
                            'name',
                            'status',
                        ],
                    ],
                    'first_page_url',
                    'from',
                    'last_page',
                    'last_page_url',
                    'links' => [],
                    'next_page_url',
                    'path',
                    'per_page',
                    'prev_page_url',
                    'to',
                    'total',
                    'current_page',
                ],
            ]);
    }

    public function test_can_retrieve_all_types()
    {
        $user = User::factory()->create();
        Type::factory()->count(5)->create();
        $response = $this->actingAs($user)->getJson('/api/task_types');
        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'name',
                        'status',
                    ],
                ],
            ]);
    }

    public function test_can_create_type()
    {
        $user = User::factory()->create();
        $typeData = [
            'name' => 'New Task Type',
            'status' => 'visible',
        ];
        $response = $this->actingAs($user)->postJson('/api/task_types', $typeData);
        $response->assertStatus(201)
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'name',
                    'status',
                ],
            ]);
        $this->assertDatabaseHas('task_types', $typeData);
    }

    public function test_can_update_type()
    {
        $user = User::factory()->create();
        $type = Type::factory()->create();
        $updatedTypeData = [
            'name' => 'Updated Task Type',
            'status' => 'hidden',
        ];
        $response = $this->actingAs($user)->putJson("/api/task_types/{$type->id}", $updatedTypeData);
        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'name',
                    'status',
                ],
            ]);
        $this->assertDatabaseHas('task_types', $updatedTypeData);
    }

    public function test_can_delete_type()
    {
        $user = User::factory()->create();
        $type = Type::factory()->create();
        $response = $this->actingAs($user)->deleteJson("/api/task_types/{$type->id}");
        $response->assertNoContent();
        $this->assertDatabaseMissing('task_types', ['id' => $type->id]);
    }
}
