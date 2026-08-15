<?php

namespace App\Http\Controllers;

use App\Applications\Projects\DTOs\ProjectCreateDto;
use App\Applications\Projects\DTOs\ProjectFilterDto;
use App\Applications\Projects\UseCases\CreateProjectUseCase;
use App\Applications\Projects\UseCases\ListProjectsUseCase;
use App\Http\Requests\{GetParamsRequest, NewProjectRequest};
use App\Http\Resources\{ProjectResource, ProjectCollection};
use Illuminate\Http\JsonResponse;

class ProjectsController extends Controller
{
  public function index(GetParamsRequest $params, ListProjectsUseCase $useCase): ProjectCollection
  { 
    $dto = ProjectFilterDto::fromArray($params->validated());
    $projects = $useCase->execute($dto);

    return new ProjectCollection($projects);
  }


  public function store(NewProjectRequest $req, CreateProjectUseCase $useCase): JsonResponse
  {
    $dto = ProjectCreateDto::fromArray($req->validated());

    $project = $useCase->execute($dto);
    return (new ProjectResource($project))
      ->setMessage('Projeto criado com sucesso.')
      ->response()
      ->setStatusCode(201);
  }
}
