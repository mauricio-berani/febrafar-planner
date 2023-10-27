<?php

namespace Tests\Feature\Api;

use App\Enums\Task\TaskStatus;
use App\Models\Task\Task;
use App\Models\Task\Type;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Tests\TestCase;

class TaskFeatureTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_retrieve_all_tasks()
    {
        $user = User::factory()->create();
        Task::factory()->count(5)->create(['user_id' => $user->id]);
        $response = $this->actingAs($user)->getJson('/api/tasks');
        $response->assertStatus(Response::HTTP_OK)
            ->assertJsonStructure([
                'message',
                'data' => [
                    '*' => [
                        'id',
                        'title',
                        'status',
                        'description',
                        'start_date',
                        'deadline',
                        'end_date',
                        'type',
                        'owner',
                    ],
                ],
            ]);
    }

    public function test_can_retrieve_a_single_task()
    {
        $user = User::factory()->create();
        $task = Task::factory()->create(['user_id' => $user->id]);
        $response = $this->actingAs($user)->getJson("/api/tasks/{$task->id}");
        $response->assertStatus(Response::HTTP_OK)
            ->assertJsonStructure([
                'message',
                'data' => [
                    'id',
                    'title',
                    'status',
                    'description',
                    'start_date',
                    'deadline',
                    'end_date',
                    'type',
                    'owner',
                ],
            ]);
    }

    public function test_can_create_a_task()
    {
        $user = User::factory()->create();
        $taskData = [
            'title' => 'New Task',
            'description' => 'Description of the task',
            'deadline' => '2023-12-29',
            'start_date' => '2023-10-31',
            'status' => TaskStatus::Pendding,
            'task_type_id' => Type::factory()->create()->id,
        ];
        $response = $this->actingAs($user)->postJson('/api/tasks', $taskData);
        $response->assertStatus(Response::HTTP_CREATED)
            ->assertJsonStructure([
                'message',
                'data' => [
                    'id',
                    'title',
                    'status',
                    'description',
                    'start_date',
                    'deadline',
                    'end_date',
                    'type',
                    'owner',
                ],
            ]);
    }

    public function test_can_update_a_task()
    {
        $user = User::factory()->create();
        $task = Task::factory()->create(['user_id' => $user->id]);
        $updatedData = [
            'title' => 'Updated Task Title',
            'description' => 'Updated description',
        ];
        $response = $this->actingAs($user)->putJson("/api/tasks/{$task->id}", $updatedData);
        $response->assertStatus(Response::HTTP_OK)
            ->assertJsonStructure([
                'message',
                'data' => [
                    'id',
                    'title',
                    'status',
                    'description',
                    'start_date',
                    'deadline',
                    'end_date',
                    'type',
                    'owner',
                ],
            ]);
        $this->assertDatabaseHas('tasks', $updatedData);
    }

    public function test_can_delete_a_task()
    {
        $user = User::factory()->create();
        $task = Task::factory()->create(['user_id' => $user->id]);
        $response = $this->actingAs($user)->deleteJson("/api/tasks/{$task->id}");
        $response->assertNoContent();
        $this->assertDatabaseMissing('tasks', ['id' => $task->id]);
    }
}
