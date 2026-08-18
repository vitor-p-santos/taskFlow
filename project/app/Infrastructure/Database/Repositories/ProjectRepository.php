<?php

namespace App\Infrastructure\Database\Repositories;

use App\Applications\Projects\DTOs\ProjectCreateDto;
use App\Applications\Projects\DTOs\ProjectFilterDto;
use App\Domain\Projects\Contracts\ProjectRepositoryInterface;
use App\Domain\Projects\Enums\ProjectStatus;
use App\Infrastructure\Database\Models\Project;
use Illuminate\Contracts\Pagination\CursorPaginator;

class ProjectRepository implements ProjectRepositoryInterface
{
    public function listWithTasksCount(ProjectFilterDto $filterData, int $perPage = 15): CursorPaginator
    {
        $projects = Project::query()
            ->withCount('tasks')
            ->latest('id')
            ->when($filterData->name, fn($projects, $name) => $projects->where('name', 'LIKE', "%{$name}%"))
            ->when($filterData->status, fn($projects, $status) => $projects->where('status', $status))
            ->cursorPaginate($perPage)
            ->withQueryString();
        return $projects;
    }

    public function create(ProjectCreateDto $data): Project
    {
        return Project::create($data->toArray());

        
    }
}
