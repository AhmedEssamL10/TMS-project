<?php

namespace App\Services;

use App\Models\Task;
use App\Models\Project;
use App\Repositories\Contracts\TaskRepositoryInterface;

class TaskService
{
    public function __construct(protected TaskRepositoryInterface $taskRepository) {}
    public function getTasksForProject(int $projectId, array $filters)
    {
        return $this->taskRepository->getAllForProject($projectId, $filters);
    }
    public function createTask(Project $project, array $data)
    {
        $data['project_id'] = $project->id;
        return $this->taskRepository->create($data);
    }
    public function updateTask(Task $task, array $data)
    {
        return $this->taskRepository->update($task, $data);
    }
    public function deleteTask(Task $task)
    {
        return $this->taskRepository->delete($task);
    }
}
