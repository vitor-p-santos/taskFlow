<?php

namespace App\Applications\Projects\UseCases;

use App\Applications\Auth\Ports\TokenGeneratorPort;
use App\Domain\Projects\Contracts\ProjectRepositoryInterface;

class GetStatisticUseCase
{
  public function __construct(
    private readonly TokenGeneratorPort $tokenGenerator,
    private readonly ProjectRepositoryInterface $projectRepository,
  ) {}

  public function execute(): array
  {
    $user = $this->tokenGenerator->getAuthenticatedUser();

    return $this->projectRepository->getDashboardStatistics($user->id);
  }
}
