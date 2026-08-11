<?php

namespace App\Http\Controllers;

use App\Actions\DeleteAction;
use App\Actions\NewAction;
use App\Actions\PatchAction;
use App\Exceptions\TaskDeleted;
use App\Http\Requests\GetParamsRequest;
use App\Http\Requests\NewTaskRequest;
use App\Http\Requests\PatchTaskRequest;
use App\Http\Resources\TaskCollection;
use App\Http\Resources\TaskResource;
use App\Repositories\ProjectRepository;
use App\Repositories\TaskRepository;
use App\Service\CheckService;
use App\Trait\ResponseTrait;


class TasksController
{
  use ResponseTrait;

  public function __construct(
    private TaskRepository $taskRepository
  ) {}
  public function get(GetParamsRequest $request, int $id, CheckService $checkService, ProjectRepository $projectRepository): TaskCollection
  {
    $findProject = $checkService->exist($projectRepository, $id);

    $tasks = $this->taskRepository->get($findProject->id, $request->validated());

    return new TaskCollection($tasks);
  }
  public function store(NewTaskRequest $req, int $id,  NewAction $newAction)
  {
    $body = $req->validated();

    $this->taskRepository->find($id);

    $body['project_id'] = $id;

    $data = $newAction($body);

    return (new TaskResource($data))->response()->setStatusCode(201);
  }
  public function patch(PatchTaskRequest $req, int $id, CheckService $checkService,  PatchAction $patchAction)
  {
    $find = $checkService->softDeleted($this->taskRepository, $id);

    $task = $patchAction($find, $req->validated());

    return new TaskResource($task);
  }
  public function delete(int $id, CheckService $checkService, DeleteAction $deleteAction)
  {
    $find = $checkService->softDeleted($this->taskRepository, $id);

    $deleteAction($find);

    return $this->success('task deleted', 200);
  }
}
