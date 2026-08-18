<?php

namespace App\Infrastructure\Database\Repositories;

use App\Applications\Tasks\DTOs\CreateTaskDTO;
use App\Applications\Tasks\DTOs\ListTasksFilterDTO;
use App\Applications\Tasks\DTOs\UpdateTaskDTO;
use App\Domain\Tasks\Contracts\TaskRepositoryInterface;
use App\Infrastructure\Database\Models\Task;
use Illuminate\Contracts\Pagination\CursorPaginator;

class TaskRepository implements TaskRepositoryInterface
{
    public function getByProjectId(ListTasksFilterDTO $filters, int $projectId): CursorPaginator
    {
        return Task::query()
            ->where('project_id', $projectId)
            ->active()
            ->when($filters->status, fn($query, $status) => $query->where('status', $status))
            ->when($filters->priority, fn($query, $priority) => $query->where('priority', $priority))
            ->when($filters->dueDate, fn($query) => $query->overdue())
            ->orderBy('id', 'desc')
            ->cursorPaginate(9)
            ->withQueryString();
    }

    public function findWithTrashed(int $id): ?Task
    {
        return Task::withTrashed()->find($id);
    }

    public function create(CreateTaskDTO $data): Task
    {
        return Task::create($data->toArray());
    }

    public function updateStatusPriority(int $taskId, UpdateTaskDTO $data): Task
    {
        $task = Task::findOrFail($taskId);
        $task->update($data->toArray());

        return $task->refresh();
    }

    public function delete(int $taskId): bool
    {
        $task = Task::findOrFail($taskId);
        
        return (bool) $task->delete();
    }
}