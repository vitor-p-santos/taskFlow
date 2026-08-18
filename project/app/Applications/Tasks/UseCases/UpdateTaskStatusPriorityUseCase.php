<?php

namespace App\Applications\Tasks\UseCases;

use App\Applications\Tasks\DTOs\UpdateTaskDTO;
use App\Domain\Tasks\Contracts\TaskRepositoryInterface;

class UpdateTaskStatusPriorityUseCase{
  
  public function __construct(
    private readonly TaskRepositoryInterface $taskRepository
  ) {}

  public function execute(int $taskId, UpdateTaskDTO $dto){
    return $this->taskRepository->updateStatusPriority($taskId,$dto);
  }
}