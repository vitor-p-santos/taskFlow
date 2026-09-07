<?php

namespace App\Domain\Projects\Contracts;

use App\Applications\Projects\DTOs\ProjectFilterDto;
use App\Domain\Projects\Entities\Project;
use App\Infrastructure\Database\Models\EloquentProject;
use Illuminate\Contracts\Pagination\CursorPaginator;

interface ProjectRepositoryInterface
{    
    public function getDashboardStatistics(string $userId): array;
    public function listWithTasksCount(ProjectFilterDto $filterData, string $userId, int $perPage = 15): CursorPaginator;
    public function create(Project $project): EloquentProject;
}