<?php
namespace App\Repositories\Eloquent;

use App\Models\Project;
use App\Repositories\Contracts\ProjectRepositoryInterface;

class ProjectRepository implements ProjectRepositoryInterface
{
    public function getAllForUser(int $userId, int $perPage = 10)
    {
        return Project::where('user_id', $userId)->latest()->paginate($perPage);
    }
    public function findById(int $id)
    {
        return Project::find($id);
    }
    public function create(array $data)
    {
        return Project::create($data);
    }
    public function update(Project $project, array $data)
    {
        $project->update($data);
        return $project;
    }
    public function delete(Project $project)
    {
        return $project->delete();
    }
}
