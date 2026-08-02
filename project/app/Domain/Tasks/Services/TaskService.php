<?php

namespace App\Domain\Tasks\Services;

use App\Domain\Tasks\Actions\DeleteAction;
use App\Domain\Tasks\Actions\NewAction;
use App\Domain\Tasks\Actions\PatchAction;
use App\Domain\Tasks\Enum\DueDateBoolean;
use App\Domain\Tasks\Enum\PriorityTask;
use App\Domain\Tasks\Enum\StatusTask;
use App\Interfaces\ActionByIdInterface;
use App\Interfaces\ActionInterface;
use App\Models\Task;
use Carbon\Carbon;

class TaskService
{

  protected ActionInterface $newAction;
  protected ActionByIdInterface $patchAction;
  protected ActionByIdInterface $deleteAction;


  public function __construct(
    NewAction $newAction,
    PatchAction $patchAction,
    DeleteAction $deleteAction
  ) {
    $this->newAction = $newAction;
    $this->patchAction = $patchAction;
    $this->deleteAction = $deleteAction;
  }

  public function all(int $id, array $query)
  {
    $queryBuilder = Task::where('project_id', $id)->where('deleted', false);

    if (StatusTask::tryFrom(data_get($query, 'status'))) {
      $queryBuilder->where('status', $query['status']);
    }

    if (PriorityTask::tryFrom(data_get($query, 'priority'))) {
      $queryBuilder->where('priority', $query['priority']);
    }

    if (DueDateBoolean::tryFrom(data_get($query, 'due_date'))) {
      $queryBuilder->overdue();
    }

    return $queryBuilder->orderBy('id', 'desc')->cursorPaginate(3);
  }
  public function create(array $data)
  {
    return ($this->newAction)($data);
  }

  public function patchField(Task $task, array $fields)
  {
    return ($this->patchAction)($task, $fields);
  }

  public function softDelete(Task $task)
  {

    $data['deleted_at'] = Carbon::now();
    $data['deleted'] = true;

    return ($this->deleteAction)($task, $data);
  }
}
