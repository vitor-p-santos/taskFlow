<?php

namespace App\Domain\Projects\Contracts;

use App\Applications\Projects\DTOs\ProjectCreateDto;
use App\Infrastructure\Database\Models\Project;
use Illuminate\Contracts\Pagination\CursorPaginator;

interface ProjectRepositoryInterface
{    
    public function listWithTasksCount(array $filterData, int $perPage = 15): CursorPaginator;
    public function create(array $data): Project;
}