<?php

namespace App\Applications\Projects\UseCases;

use App\Applications\Auth\Ports\TokenGeneratorPort;
use App\Applications\Projects\DTOs\ProjectCreateDto;
use App\Domain\Projects\Contracts\ProjectRepositoryInterface;
use App\Domain\Projects\Entities\Project;
use App\Infrastructure\Database\Models\EloquentProject;

class CreateProjectUseCase
{
    public function __construct(
        private readonly ProjectRepositoryInterface $projectRepository,
        private readonly TokenGeneratorPort $tokenGenerator
    ) {}

    public function execute(ProjectCreateDto $dto): EloquentProject
    {
        $user = $this->tokenGenerator->getAuthenticatedUser();

        $project = new Project(
            $user->id,
            $dto->name,
            $dto->description,
            $dto->status
        );
        return $this->projectRepository->create($project);
    }
}
