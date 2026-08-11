<?php

namespace App\Repositories;

use App\Enums\StatusProject;
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

    public function all(array $filter)
    {
        $queryBuilder = $this->model->withCount('tasks');

        if (StatusProject::tryFrom(data_get($filter, 'status'))) {
            $queryBuilder->where('status', $filter['status']);
        }

        if (!empty(data_get($filter, 'name'))) {
            $name = trim($filter['name']);

                $queryBuilder->whereLike('name', "%{$name}%");
        }

        return $queryBuilder
            ->orderBy('id', 'desc')
            ->cursorPaginate(9)
            ->withQueryString();
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
