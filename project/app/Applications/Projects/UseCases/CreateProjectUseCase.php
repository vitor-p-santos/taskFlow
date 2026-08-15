<?php

namespace App\Applications\Projects\UseCases;

use App\Applications\Projects\DTOs\ProjectCreateDto;
use App\Domain\Projects\Contracts\ProjectRepositoryInterface;
use App\Infrastructure\Database\Models\Project;

class CreateProjectUseCase
{
    public function __construct(
        private readonly ProjectRepositoryInterface $projectRepository
    ) {}

    public function execute(ProjectCreateDto $dto): Project
    {
        return $this->projectRepository->create($dto->toArray());
    }
}