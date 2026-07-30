<?php

namespace App\Domain\Tasks\Repository;

use App\Models\Task;
use Illuminate\Database\Eloquent\Model;

class TaskRepository
{
  protected Model $model;

  public function __construct(Task $model)
  {
    $this->model = $model;
  }

  public function find(int $id): Task|null
  {
    return $this->model->find($id);
  }
}
