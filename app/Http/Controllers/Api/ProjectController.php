<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProjectRequest;
use App\Http\Resources\ProjectResource;
use App\Models\Project;
use App\Services\ProjectService;
use App\Traits\ApiResponse;

class ProjectController extends Controller
{
    use ApiResponse;
    public function __construct(
        protected ProjectService $projectService
    ) {}
    public function index()
    {
        $projects = $this->projectService->getUserProjects();
        return $this->success( ProjectResource::collection($projects)->response()->getData(true),'projects retrieved successfully', 200);
    }
    public function store(ProjectRequest $request)
    {
        $project = $this->projectService->createProject($request->validated());
        return $this->success([], 'Project created successfully', 201);
    }
    public function show(Project $project)
    {
        if ($project->user_id !== auth()->id()) {
            return $this->error('Unauthorized', 403);
        }
        return $this->success(new ProjectResource($project), 'Project retrieved successfully', 200);
    }
    public function update(ProjectRequest $request, Project $project)
    {
        if ($project->user_id !== auth()->id()) {
            return $this->error('Unauthorized', 403);
        }
        $updatedProject = $this->projectService->updateProject($project, $request->validated());
        return $this->success([], 'Project updated successfully', 200);
    }
    public function destroy(Project $project)
    {
        if ($project->user_id !== auth()->id()) {
            return $this->error('Unauthorized', 403);
        }
        $this->projectService->deleteProject($project);
        return $this->success([], 'Project deleted successfully', 200);
    }
}
