<?php

namespace App\Applications\Tasks\UseCases;

use App\Applications\Tasks\DTOs\ListTasksFilterDTO;
use App\Domain\Tasks\Contracts\TaskRepositoryInterface;
use Illuminate\Contracts\Pagination\CursorPaginator;

class ListProjectTasksUseCase
{
    public function __construct(
        private readonly TaskRepositoryInterface $taskRepository
    ) {}

    public function execute(ListTasksFilterDTO $dto, int $projectId): CursorPaginator
    {
        // Envia o DTO completo para o Repositório
        return $this->taskRepository->getByProjectId($dto, $projectId);
    }
}