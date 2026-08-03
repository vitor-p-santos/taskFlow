<?php

namespace App\Http\Controllers;

use App\Domain\Projects\Requests\NewProjectRequest;
use App\Domain\Projects\Resources\ProjectResource;
use App\Domain\Projects\Services\{NewProjectService, ProjectService};
use App\Trait\ResponseTrait;
use Illuminate\Database\QueryException;
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

    return $this->success(
      'Projects found',
      200,
      ProjectResource::collection($projects)->collection,
      [
        'next_cursor'    => optional($projects->nextCursor())->encode(),
        'next_page_url'  => $projects->nextPageUrl(),
        'prev_cursor'    => optional($projects->previousCursor())->encode(),
        'prev_page_url'  => $projects->previousPageUrl(),
        'has_more'       => $projects->hasMorePages(),
      ]
    );
  }

  public function store(NewProjectRequest $req): JsonResponse
  {
    $project = $this->projectService->create($req->validated());

    $projectResource = new ProjectResource($project);

    return $this->success('project created', 201, $projectResource);
  }
}
