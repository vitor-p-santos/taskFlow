<?php

namespace App\Infrastructure\Database\Repositories;

use App\Applications\Projects\DTOs\ProjectFilterDto;
use App\Domain\Projects\Contracts\ProjectRepositoryInterface;
use App\Domain\Projects\Entities\Project;
use App\Infrastructure\Database\Models\EloquentProject;
use App\Infrastructure\Database\Models\EloquentTask;
use Illuminate\Contracts\Pagination\CursorPaginator;

class ProjectRepository implements ProjectRepositoryInterface
{
    public function getDashboardStatistics(int $userId): array
    {
        $projectStats = EloquentProject::where('user_id', $userId)
            ->selectRaw('count(*) as total')
            ->selectRaw("sum(case when status = 'active' then 1 else 0 end) as active")
            ->selectRaw("sum(case when status = 'archived' then 1 else 0 end) as archived")
            ->first();

        $taskStats = EloquentTask::whereHas('project', function ($query) use ($userId) {
            $query->where('user_id', $userId);
        })
            ->selectRaw('count(*) as total')
            ->selectRaw("sum(case when status = 'todo' then 1 else 0 end) as todo")
            ->selectRaw("sum(case when status = 'in_progress' then 1 else 0 end) as in_progress")
            ->selectRaw("sum(case when status = 'done' then 1 else 0 end) as done")
            ->first();

        return [
            'projects' => [
                'total'    => (int) ($projectStats->total ?? 0),
                'active'   => (int) ($projectStats->active ?? 0),
                'archived' => (int) ($projectStats->archived ?? 0),
            ],
            'tasks' => [
                'total'       => (int) ($taskStats->total ?? 0),
                'todo'        => (int) ($taskStats->todo ?? 0),
                'in_progress' => (int) ($taskStats->in_progress ?? 0),
                'done'        => (int) ($taskStats->done ?? 0),
            ]
        ];
    }
    public function listWithTasksCount(ProjectFilterDto $filterData, int $userId, int $perPage = 15): CursorPaginator
    {
        $projects = EloquentProject::query()
            ->withCount('tasks')
            ->latest('id')
            ->when($filterData->name, fn($projects, $name) => $projects->where('name', 'LIKE', "%{$name}%"))
            ->when($filterData->status, fn($projects, $status) => $projects->where('status', $status))
            ->cursorPaginate($perPage)
            ->withQueryString();
        return $projects;
    }

    public function create(Project $project): EloquentProject
    {
        return EloquentProject::create([
            'user_id' => $project->userId,
            'name' => $project->name,
            'description' => $project->description,
            'status' => $project->status->value,
        ]);
    }
}
