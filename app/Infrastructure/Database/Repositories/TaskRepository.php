<?php

namespace App\Infrastructure\Database\Repositories;

use App\Applications\Tasks\DTOs\CreateTaskDTO;
use App\Applications\Tasks\DTOs\ListTasksFilterDTO;
use App\Applications\Tasks\DTOs\UpdateTaskDTO;
use App\Domain\Tasks\Contracts\TaskRepositoryInterface;
use App\Domain\Tasks\Entities\Task;
use App\Infrastructure\Database\Models\EloquentTask;
use Illuminate\Contracts\Pagination\CursorPaginator;

class TaskRepository implements TaskRepositoryInterface
{
    public function getByProjectId(ListTasksFilterDTO $filters, int $projectId): CursorPaginator
    {
        return EloquentTask::query()
            ->where('project_id', $projectId)
            ->active()
            ->when($filters->status, fn($query, $status) => $query->where('status', $status))
            ->when($filters->priority, fn($query, $priority) => $query->where('priority', $priority))
            ->when($filters->dueDate, fn($query) => $query->overdue())
            ->orderBy('id', 'desc')
            ->cursorPaginate(9)
            ->withQueryString();
    }

    public function findWithTrashed(int $id): EloquentTask
    {
        return EloquentTask::withTrashed()->find($id);
    }

    public function create(Task $task): EloquentTask
    {
        return EloquentTask::create([
            'project_id' => $task->projectId,
            'title' => $task->title,
            'description' => $task->description,
            'status' => $task->status->value,
            'priority' => $task->priority->value,
            'due_date' => $task->dueDate,
        ]);
    }

    public function updateStatusPriority(int $taskId, UpdateTaskDTO $data): EloquentTask
    {
        $task = EloquentTask::findOrFail($taskId);
        $task->update($data->toArray());

        return $task->refresh();
    }

    public function delete(int $taskId): bool
    {
        $task = EloquentTask::findOrFail($taskId);
        
        return (bool) $task->delete();
    }
}