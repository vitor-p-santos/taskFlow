<?php

namespace App\Domain\Tasks\Contracts;

use App\Applications\Tasks\DTOs\ListTasksFilterDTO;
use App\Infrastructure\Database\Models\Task;
use Illuminate\Contracts\Pagination\CursorPaginator;

interface TaskRepositoryInterface
{
    public function getByProjectId(ListTasksFilterDTO $filters, int $projectId): CursorPaginator;
    public function findWithTrashed(int $taskId): ?Task;
    public function create(array $data): Task;
    public function update(int $taskId, array $data): Task;
    public function delete(int $taskId): bool;
}