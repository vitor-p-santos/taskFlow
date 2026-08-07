<?php

namespace App\Domain\Projects\Services;

use App\Domain\Projects\Actions\NewAction;
use App\Domain\Projects\Repository\ProjectRepository;
use App\Interfaces\ActionInterface;
use App\Models\Project;

class ProjectService
{
  protected ProjectRepository $projectRepository;
  protected ActionInterface $newAction;

  public function __construct(
    NewAction $newAction,
    ProjectRepository $projectRepository
  ) {
    $this->newAction = $newAction;
    $this->projectRepository = $projectRepository;
  }

  public function create(array $data): Project
  {
    return ($this->newAction)($data);
  }
  public function get(array $filter)
  {
    return $this->projectRepository->all($filter);
  }
}
