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
    $allowedFilters = ['name', 'status', 'cursor'];

    $queryKeys = array_keys(request()->query());

    $hasInvalidParams = !empty(array_diff($queryKeys, $allowedFilters));

    if ($hasInvalidParams || !empty($queryKeys['name']) && $queryKeys['name'] == '') {
      return $this->success(
        'Projects found',
        200,
        ['nada'],
        [
          'next_cursor'    => null,
          'next_page_url'  => null,
          'prev_cursor'    => null,
          'prev_page_url'  => null,
          'has_more'       => false,
        ]
      );
    }

    $projects = $this->projectService->get(request()->only($allowedFilters));

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
