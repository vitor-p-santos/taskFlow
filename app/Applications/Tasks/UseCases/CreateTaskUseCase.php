<?php

namespace App\Applications\Tasks\UseCases;

use App\Applications\Tasks\DTOs\CreateTaskDTO;
use App\Domain\Tasks\Contracts\TaskRepositoryInterface;
use App\Domain\Tasks\Entities\Task;

class CreateTaskUseCase
{
  public function __construct(
    private readonly TaskRepositoryInterface $taskRepository
  ) {}

  public function execute(CreateTaskDTO $dto)
  {

    $task = new Task(
      $dto->projectId,
      $dto->title,
      $dto->description,
      $dto->status,
      $dto->priority,
      $dto->dueDate
    );

    return $this->taskRepository->create($task);
  }
}
