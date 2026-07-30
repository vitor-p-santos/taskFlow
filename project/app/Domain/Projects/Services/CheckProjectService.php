<?php

namespace App\Domain\Projects\Services;

use App\Domain\Projects\Repository\ProjectRepository;
use App\Exceptions\NotFound;

class CheckProjectService
{
  protected ProjectRepository $projectRepository;

  public function __construct(ProjectRepository $projectRepository)
  {
    $this->projectRepository = $projectRepository;
  }
  public function find(int $id)
  {

    $find = $this->projectRepository->find($id);

    if (!$find) {
      throw new NotFound('Project not found');
    }

    return $find;
  }
}
