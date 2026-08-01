<?php
namespace App\Repositories\Eloquent;

use App\Models\Task;
use App\Repositories\Contracts\TaskRepositoryInterface;
use Illuminate\Database\Eloquent\Builder;

class TaskRepository implements TaskRepositoryInterface
{
    public function getAllForProject(int $projectId, array $filters = [], int $perPage = 10)
    {
        return Task::where('project_id', $projectId)
            ->when($filters['status'] ?? null, function (Builder $query, $status) {
                $query->where('status', $status);
            })
            ->when($filters['priority'] ?? null, function (Builder $query, $priority) {
                $query->where('priority', $priority);
            })
            ->when($filters['search'] ?? null, function (Builder $query, $search) {
                $query->where('title', 'like', '%' . $search . '%');
            })
            ->latest()
            ->paginate($perPage);
    }
    public function findById(int $id)
    {
        return Task::find($id);
    }
    public function create(array $data)
    {
        return Task::create($data);
    }
    public function update(Task $task, array $data)
    {
        $task->update($data);
        return $task;
    }
    public function delete(Task $task): bool
    {
        return $task->delete();
    }
}
