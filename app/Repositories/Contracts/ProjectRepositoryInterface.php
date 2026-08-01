<?php

namespace App\Repositories\Contracts;

use App\Models\Project;

interface ProjectRepositoryInterface
{
    public function getAllForUser(int $userId, int $perPage = 10);
    public function findById(int $id);
    public function create(array $data);
    public function update(Project $project, array $data);
    public function delete(Project $project);
}
