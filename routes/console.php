<?php
use Illuminate\Support\Facades\Schedule;
use App\Models\Task;
use App\Jobs\NotifyOverdueTask;
use App\Enums\TaskStatus;

Schedule::call(function () {
    $overdueTasks = Task::with('project.user')
        ->where('status', '!=', TaskStatus::DONE->value)
        ->where('due_date', '<', now())
        ->get();
    foreach ($overdueTasks as $task) {
        NotifyOverdueTask::dispatch($task);
    }
})->daily();
