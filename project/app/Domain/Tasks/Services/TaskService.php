<?php

namespace App\Domain\Tasks\Services;

use App\Domain\Tasks\Actions\DeleteAction;
use App\Domain\Tasks\Actions\NewAction;
use App\Domain\Tasks\Actions\PatchAction;
use App\Domain\Tasks\Enum\DueDateBoolean;
use App\Domain\Tasks\Enum\PriorityTask;
use App\Domain\Tasks\Enum\StatusTask;
use App\Domain\Tasks\Repository\TaskRepository;
use App\Interfaces\ActionByIdInterface;
use App\Interfaces\ActionInterface;
use App\Interfaces\RepositoryInterface;
use App\Models\Task;
use Carbon\Carbon;

class TaskService
{

  protected RepositoryInterface $repository;

  protected ActionInterface $newAction;
  protected ActionByIdInterface $patchAction;
  protected ActionByIdInterface $deleteAction;


  public function __construct(
    NewAction $newAction,
    PatchAction $patchAction,
    DeleteAction $deleteAction,
   TaskRepository $taskRepository
  ) {
    $this->newAction = $newAction;
    $this->patchAction = $patchAction;
    $this->deleteAction = $deleteAction;
    $this->repository = $taskRepository;
  }

  public function all(int $id, array $query)
  {
    return $this->repository->get($id, $query);
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

    return ($this->deleteAction)($task);
  }
}
