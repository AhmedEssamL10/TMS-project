<?php

namespace Database\Seeders;

use App\Enums\TaskPriority;
use App\Enums\TaskStatus;
use App\Models\Project;
use App\Models\Task;
use Illuminate\Database\Seeder;

class TaskSeeder extends Seeder
{
    public function run(): void
    {
        $projects = Project::all();

        $tasksByProject = [
            'Alpha Launch' => [
                [
                    'title' => 'Finalize onboarding checklist',
                    'description' => 'Review all onboarding steps and confirm launch readiness.',
                    'priority' => TaskPriority::HIGH->value,
                    'status' => TaskStatus::TODO->value,
                    'due_date' => now()->addDays(3),
                ],
                [
                    'title' => 'Prepare release notes',
                    'description' => 'Draft release notes and share them with the support team.',
                    'priority' => TaskPriority::MEDIUM->value,
                    'status' => TaskStatus::IN_PROGRESS->value,
                    'due_date' => now()->addDays(5),
                ],
            ],
            'Website Refresh' => [
                [
                    'title' => 'Review wireframes',
                    'description' => 'Validate the new homepage structure with the design team.',
                    'priority' => TaskPriority::MEDIUM->value,
                    'status' => TaskStatus::TODO->value,
                    'due_date' => now()->addDays(7),
                ],
            ],
            'Mobile App Beta' => [
                [
                    'title' => 'Collect beta feedback',
                    'description' => 'Summarize feedback from beta users and prioritize fixes.',
                    'priority' => TaskPriority::HIGH->value,
                    'status' => TaskStatus::DONE->value,
                    'due_date' => now()->subDay(),
                ],
            ],
        ];

        foreach ($projects as $project) {
            foreach ($tasksByProject[$project->name] ?? [] as $taskData) {
                Task::firstOrCreate(
                    ['project_id' => $project->id, 'title' => $taskData['title']],
                    array_merge($taskData, ['project_id' => $project->id])
                );
            }
        }
    }
}
