<?php

namespace App\Domain\Projects\Repository;

use App\Models\Project;
use Illuminate\Database\Eloquent\Model;

class ProjectRepository
{
    protected Model $model;

    public function __construct(Project $model)
    {
        $this->model = $model;
    }

    public function all()
    {
        return $this->model->withCount('tasks')
            ->orderBy('id', 'desc')
            ->cursorPaginate(9);
    }
    public function find(int $id): Project|null
    {
        return $this->model->find($id);
    }
}
