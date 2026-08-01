<?php

namespace App\Http\Controllers\Api;

use App\Enums\ProjectStatus;
use App\Enums\TaskStatus;
use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\Task;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;

class DashboardController extends Controller
{
    use ApiResponse;
    public function index(): JsonResponse
    {
        $userId = auth()->id();
        $totalProjects = Project::where('user_id', $userId)->count();
        $activeProjects = Project::where('user_id', $userId)->where('status', ProjectStatus::ACTIVE->value)->count();
        $tasksQuery = Task::whereHas('project', function ($query) use ($userId) {
            $query->where('user_id', $userId);
        });
        $totalTasks = (clone $tasksQuery)->count();
        $completedTasks = (clone $tasksQuery)->where('status', TaskStatus::DONE->value)->count();
        $pendingTasks = (clone $tasksQuery)->whereIn('status', [TaskStatus::TODO->value, TaskStatus::IN_PROGRESS->value])->count();
        $overdueTasks = (clone $tasksQuery)->where('due_date', '<', now())->where('status', '!=', TaskStatus::DONE->value)->count();
        return $this->success(
            [
                'total_projects' => $totalProjects,
                'active_projects' => $activeProjects,
                'total_tasks' => $totalTasks,
                'completed_tasks' => $completedTasks,
                'pending_tasks' => $pendingTasks,
                'overdue_tasks' => $overdueTasks,
            ],
            'Dashboard data retrieved successfully',
            200,
        );
    }
}
