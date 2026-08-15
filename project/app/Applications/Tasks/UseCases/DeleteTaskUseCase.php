<?php

namespace App\Applications\Tasks\UseCases;

use App\Domain\Tasks\Contracts\TaskRepositoryInterface;

class DeleteTaskUseCase
{
  public function __construct(
    private readonly TaskRepositoryInterface $taskRepository
  ) {}

  public function execute(int $taskId){
    return $this->taskRepository->delete($taskId);
  }
}
