<?php

namespace App\Applications\Tasks\UseCases;

use App\Applications\Tasks\DTOs\CreateTaskDTO;
use App\Domain\Tasks\Contracts\TaskRepositoryInterface;

class CreateTaskUseCase
{
  public function __construct(
    private readonly TaskRepositoryInterface $taskRepository
  ) {}

  public function execute(CreateTaskDTO $dto){
    return $this->taskRepository->create($dto);
  }
}
