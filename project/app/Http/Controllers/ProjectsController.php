<?php

namespace App\Http\Controllers;

use App\Http\Requests\GetParamsRequest;
use App\Http\Requests\NewProjectRequest;
use App\Http\Resources\ProjectResource;
use App\Actions\NewProject;
use App\Http\Resources\ProjectCollection;
use App\Repositories\ProjectRepository;
use Illuminate\Http\JsonResponse;

class ProjectsController extends Controller
{
  public function get(GetParamsRequest $getParamsRequest, ProjectRepository $projectRepository): ProjectCollection
  {
    $filter = $getParamsRequest->validated();

    $projects = $projectRepository->all($filter);

    return new ProjectCollection($projects);
  }


  public function store(NewProjectRequest $req, NewProject $newProject): JsonResponse
  {
    $project = $newProject($req->validated());

    return (new ProjectResource($project))
      ->setMessage('Projeto criado com sucesso.')
      ->response()
      ->setStatusCode(201);
  }
}
