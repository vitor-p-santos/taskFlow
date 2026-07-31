<?php

namespace App\Http\Controllers;

use App\Domain\Projects\Requests\NewProjectRequest;
use App\Domain\Projects\Resources\ProjectResource;
use App\Domain\Projects\Services\{NewProjectService, ProjectService};
use App\Trait\ResponseTrait;
use Illuminate\Http\JsonResponse;

class ProjectsController extends Controller
{
  use ResponseTrait;

  private ProjectService $projectService;

  public function __construct(
    ProjectService $projectService
  ) {
    $this->projectService = $projectService;
  }

  public function get(): JsonResponse
  {
    $projects = $this->projectService->get();

    $projectResource = $projects ? ProjectResource::collection($projects) : [];
    
    return $this->success('projects found', 200, $projectResource);
  }

  public function store(NewProjectRequest $req): JsonResponse
  {
    $project = $this->projectService->create($req->validated());

    $projectResource = new ProjectResource($project);

    return $this->success('project created', 201, $projectResource);
  }
}
