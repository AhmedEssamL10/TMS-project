<?php

namespace Tests\Feature;

use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use App\Enums\TaskStatus;
use App\Enums\TaskPriority;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_create_task_for_their_project()
    {
        $user = User::factory()->create();
        $project = Project::factory()->create(['user_id' => $user->id]);

        $payload = [
            'title' => 'New API Endpoint',
            'priority' => TaskPriority::HIGH->value,
            'status' => TaskStatus::TODO->value,
        ];

        $response = $this->actingAs($user, 'sanctum')->postJson("/api/projects/{$project->id}/tasks", $payload);

        $response->assertStatus(201)->assertJsonPath('data.title', 'New API Endpoint');
        $this->assertDatabaseHas('tasks', ['title' => 'New API Endpoint', 'project_id' => $project->id]);
    }

    public function test_tasks_can_be_filtered_by_status()
    {
        $user = User::factory()->create();
        $project = Project::factory()->create(['user_id' => $user->id]);

        Task::factory()->create(['project_id' => $project->id, 'status' => TaskStatus::DONE->value]);
        Task::factory()->create(['project_id' => $project->id, 'status' => TaskStatus::TODO->value]);

        $response = $this->actingAs($user, 'sanctum')->getJson("/api/projects/{$project->id}/tasks?status=done");

        $response->assertStatus(200)
                 ->assertJsonCount(1, 'data')
                 ->assertJsonPath('data.0.status', TaskStatus::DONE->value);
    }
}
