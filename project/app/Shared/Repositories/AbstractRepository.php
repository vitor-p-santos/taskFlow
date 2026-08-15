<?php

namespace App\Shared\Repositories;

use App\Shared\Contracts\RepositoryInterface;
use Illuminate\Database\Eloquent\Model;

abstract class AbstractRepository implements RepositoryInterface
{
    protected Model $model;

    abstract protected function model(): string;

    public function __construct()
    {
        $this->model = app($this->model());
    }

    public function find(int $id): ?Model
    {
        return $this->model->find($id);
    }
    public function destroy(int $id): bool
    {
        return $this->find($id)->delete();
    }
}
