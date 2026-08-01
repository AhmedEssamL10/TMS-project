<?php
namespace Tests\Feature;

use App\Models\Project;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProjectApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_list_their_own_projects()
    {
        $user = User::factory()->create();
        Project::factory()->count(3)->create(['user_id' => $user->id]);
        Project::factory()->count(2)->create(); // Someone else's projects

        $response = $this->actingAs($user, 'sanctum')->getJson('/api/projects');

        $response->assertStatus(200)
                 ->assertJsonCount(3, 'data'); // Should only see their 3
    }

    public function test_user_cannot_update_someone_elses_project()
    {
        $user = User::factory()->create();
        $otherUser = User::factory()->create();
        $project = Project::factory()->create(['user_id' => $otherUser->id]);

        $response = $this->actingAs($user, 'sanctum')->putJson("/api/projects/{$project->id}", [
            'name' => 'Hacked Project'
        ]);

        $response->assertStatus(403); // Forbidden
        $this->assertDatabaseMissing('projects', ['name' => 'Hacked Project']);
    }

    public function test_user_can_delete_project()
    {
        $user = User::factory()->create();
        $project = Project::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user, 'sanctum')->deleteJson("/api/projects/{$project->id}");

        $response->assertStatus(204);
        $this->assertSoftDeleted('projects', ['id' => $project->id]); // Proves soft deletes work
    }
}
