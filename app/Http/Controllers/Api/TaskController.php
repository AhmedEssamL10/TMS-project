<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\TaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Http\Resources\TaskResource;
use App\Models\Project;
use App\Models\Task;
use App\Services\TaskService;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class TaskController extends Controller
{
    use ApiResponse;
    public function __construct(protected TaskService $taskService) {}
    public function index(Request $request, Project $project)
    {
        if ($project->user_id !== auth()->id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }
        $filters = $request->only(['status', 'priority', 'search']);
        $tasks = $this->taskService->getTasksForProject($project->id, $filters);

        return $this->success(TaskResource::collection($tasks)->response()->getData(true), 'Tasks retrieved successfully', 200);
    }
    public function store(TaskRequest $request, Project $project)
    {
        if ($project->user_id !== auth()->id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }
        $task = $this->taskService->createTask($project, $request->validated());
        return $this->success([],'Task created successfully', 201);
    }
    public function show(Task $task)
    {
        if ($task->project->user_id !== auth()->id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }
        return $this->success(new TaskResource($task), 'Task retrieved successfully', 200);
    }
    public function update(TaskRequest $request, Task $task)
    {
        if ($task->project->user_id !== auth()->id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }
        $updatedTask = $this->taskService->updateTask($task, $request->validated());
        return $this->success([], 'Task updated successfully', 200);
    }
    public function destroy(Task $task)
    {
        if ($task->project->user_id !== auth()->id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }
        $this->taskService->deleteTask($task);
        return $this->success([], 'Task deleted successfully', 200);
    }
}
