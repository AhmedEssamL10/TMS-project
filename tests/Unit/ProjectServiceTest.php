<?php
namespace Tests\Unit;

use App\Models\Project;
use App\Repositories\Contracts\ProjectRepositoryInterface;
use App\Services\ProjectService;
use Illuminate\Support\Facades\Auth;
use Mockery;
use PHPUnit\Framework\TestCase;

class ProjectServiceTest extends TestCase
{
    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    public function test_it_assigns_auth_user_id_when_creating_project()
    {
        // 1. Mock Laravel's Auth facade to return a fake User ID
        Auth::shouldReceive('id')->once()->andReturn(99);

        // 2. Mock the Repository
        $mockRepository = Mockery::mock(ProjectRepositoryInterface::class);

        // We expect the repository's 'create' method to be called exactly once
        // with the user_id appended to the data array.
        $mockRepository->shouldReceive('create')
            ->once()
            ->with([
                'name' => 'My Test Project',
                'user_id' => 99
            ])
            ->andReturn(new Project(['name' => 'My Test Project', 'user_id' => 99]));

        // 3. Inject the mock into the Service
        $service = new ProjectService($mockRepository);

        // 4. Run the method and assert
        $project = $service->createProject(['name' => 'My Test Project']);

        $this->assertEquals(99, $project->user_id);
        $this->assertEquals('My Test Project', $project->name);
    }
}
