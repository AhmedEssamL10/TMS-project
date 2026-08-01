<?php

namespace App\Repositories\Contracts;

use App\Models\Task;

interface TaskRepositoryInterface
{
    public function getAllForProject(int $projectId, array $filters = [], int $perPage = 10);
    public function findById(int $id);
    public function create(array $data);
    public function update(Task $task, array $data);
    public function delete(Task $task);
}
