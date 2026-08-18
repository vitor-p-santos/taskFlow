<?php

namespace App\Domain\Tasks\Contracts;

use App\Applications\Tasks\DTOs\CreateTaskDTO;
use App\Applications\Tasks\DTOs\ListTasksFilterDTO;
use App\Applications\Tasks\DTOs\UpdateTaskDTO;
use App\Infrastructure\Database\Models\Task;
use Illuminate\Contracts\Pagination\CursorPaginator;

interface TaskRepositoryInterface
{
    public function getByProjectId(ListTasksFilterDTO $filters, int $projectId): CursorPaginator;
    public function findWithTrashed(int $taskId): ?Task;
    public function create(CreateTaskDTO $data): Task;
    public function updateStatusPriority(int $taskId, UpdateTaskDTO $data): Task;
    public function delete(int $taskId): bool;
}