<?php

namespace App\Applications\Projects\UseCases;

use App\Applications\Projects\DTOs\ProjectFilterDto;
use App\Domain\Projects\Contracts\ProjectRepositoryInterface;
use Illuminate\Contracts\Pagination\CursorPaginator;

class ListProjectsUseCase
{
    public function __construct(
        private readonly ProjectRepositoryInterface $projectRepository
    ) {}

    public function execute(ProjectFilterDto $dto, int $perPage = 15): CursorPaginator
    {
        return $this->projectRepository->listWithTasksCount($dto->toArray(), $perPage);
    }
}