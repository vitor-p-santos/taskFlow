<?php

namespace App\Domain\Tasks\Contracts;

use App\Applications\Tasks\DTOs\CreateTaskDTO;
use App\Applications\Tasks\DTOs\ListTasksFilterDTO;
use App\Applications\Tasks\DTOs\UpdateTaskDTO;
use App\Domain\Tasks\Entities\Task;
use App\Infrastructure\Database\Models\EloquentTask;
use Illuminate\Contracts\Pagination\CursorPaginator;

interface TaskRepositoryInterface
{
    public function getByProjectId(ListTasksFilterDTO $filters, int $projectId): CursorPaginator;
    public function findWithTrashed(int $taskId): ?EloquentTask;
    public function create(Task $data): EloquentTask;
    public function updateStatusPriority(int $taskId, UpdateTaskDTO $data): EloquentTask;
    public function delete(int $taskId): bool;
}