<?php

namespace App\Domain\Tasks\Services;

use App\Domain\Tasks\Exceptions\TaskDeleted;
use App\Domain\Tasks\Repository\TaskRepository;
use App\Exceptions\NotFound;
use App\Interfaces\RepositoryInterface;

class CheckTaskService
{
  protected RepositoryInterface $repository;

  public function __construct(TaskRepository $taskRepository)
  {
    $this->repository = $taskRepository;
  }

  public function findTask(int $id)
  {

    $find = $this->repository->find($id);

    if (!$find) {
      throw new NotFound('task not found');
    }

    return $find;
  }
  public function checkSoftDelete(int $id)
  {
    $find = $this->findTask($id);
    
    if ($find->deleted) {
      throw new TaskDeleted();
    }

    return $find;
  }
}
