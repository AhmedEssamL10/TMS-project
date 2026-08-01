<?php
namespace Database\Factories;

use App\Enums\TaskPriority;
use App\Enums\TaskStatus;
use App\Models\Project;
use Illuminate\Database\Eloquent\Factories\Factory;

class TaskFactory extends Factory
{
    public function definition(): array
    {
        return [
            'project_id' => Project::factory(),
            'title' => fake()->sentence(4),
            'description' => fake()->paragraph(),
            'priority' => TaskPriority::MEDIUM->value,
            'status' => TaskStatus::TODO->value,
            'due_date' => fake()->dateTimeBetween('now', '+1 month'),
        ];
    }
}
