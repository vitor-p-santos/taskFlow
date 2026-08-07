<?php

namespace App\Domain\Tasks\Repository;

use App\Domain\Tasks\Enum\DueDateBoolean;
use App\Domain\Tasks\Enum\PriorityTask;
use App\Domain\Tasks\Enum\StatusTask;
use App\Interfaces\RepositoryInterface;
use App\Models\Task;
use Illuminate\Database\Eloquent\Model;

class TaskRepository implements RepositoryInterface
{
  protected Model $model;

  public function __construct(Task $model)
  {
    $this->model = $model;
  }
  public function all(array  $filter)
  {
    //
  }
  public function get(int $id, array $query)
  {
    $queryBuilder = $this->model->where('project_id', $id)->where('deleted', false);

    if (StatusTask::tryFrom(data_get($query, 'status'))) {
      $queryBuilder->where('status', $query['status']);
    }

    if (PriorityTask::tryFrom(data_get($query, 'priority'))) {
      $queryBuilder->where('priority', $query['priority']);
    }

    if (DueDateBoolean::tryFrom(data_get($query, 'due_date'))) {
      $queryBuilder->overdue();
    }

    return $queryBuilder->orderBy('id', 'desc')
      ->cursorPaginate(9)
      ->withQueryString();
  }

  public function find(int $id): Task|null
  {
    return $this->model->find($id);
  }
}
