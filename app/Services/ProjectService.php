<?php
namespace App\Services;

use App\Models\Project;
use App\Repositories\Contracts\ProjectRepositoryInterface;
use Illuminate\Support\Facades\Auth;

class ProjectService
{
    public function __construct(
        protected ProjectRepositoryInterface $projectRepository
    ) {}

    public function getUserProjects()
    {
        return $this->projectRepository->getAllForUser(Auth::id());
    }
    public function createProject(array $data)
    {
        $data['user_id'] = Auth::id();
        return $this->projectRepository->create($data);
    }
    public function updateProject(Project $project, array $data)
    {
        return $this->projectRepository->update($project, $data);
    }
    public function deleteProject(Project $project)
    {
        return $this->projectRepository->delete($project);
    }
}
