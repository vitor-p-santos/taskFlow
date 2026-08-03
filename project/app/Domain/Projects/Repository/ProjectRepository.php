<?php

namespace App\Domain\Projects\Repository;

use App\Interfaces\RepositoryInterface;
use App\Models\Project;
use Illuminate\Database\Eloquent\Model;

class ProjectRepository implements RepositoryInterface
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

    public function get(int $id, array $data)
    {
        //
    }
    
    public function find(int $id): Project|null
    {
        return $this->model->find($id);
    }
}
