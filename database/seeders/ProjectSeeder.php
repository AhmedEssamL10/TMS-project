<?php

namespace Database\Seeders;

use App\Enums\ProjectStatus;
use App\Models\Project;
use App\Models\User;
use Illuminate\Database\Seeder;

class ProjectSeeder extends Seeder
{
    public function run(): void
    {
        $owner = User::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin User',
                'password' => bcrypt('password123'),
            ]
        );

        $projects = [
            [
                'name' => 'Alpha Launch',
                'description' => 'Prepare the launch plan and release checklist for the new client portal.',
                'status' => ProjectStatus::ACTIVE->value,
            ],
            [
                'name' => 'Website Refresh',
                'description' => 'Redesign the marketing website with a modern UI and improved content blocks.',
                'status' => ProjectStatus::ACTIVE->value,
            ],
            [
                'name' => 'Mobile App Beta',
                'description' => 'Coordinate the beta rollout and capture early feedback from users.',
                'status' => ProjectStatus::COMPLETED->value,
            ],
        ];

        foreach ($projects as $project) {
            Project::firstOrCreate(
                ['name' => $project['name'], 'user_id' => $owner->id],
                array_merge($project, ['user_id' => $owner->id])
            );
        }
    }
}
