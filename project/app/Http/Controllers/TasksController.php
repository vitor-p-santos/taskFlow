<?php

namespace App\Http\Controllers;

use App\Applications\Tasks\DTOs\{ListTasksFilterDTO, CreateTaskDTO, UpdateTaskDTO};
use App\Applications\Tasks\UseCases\{ListProjectTasksUseCase, CreateTaskUseCase, UpdateTaskStatusPriorityUseCase, DeleteTaskUseCase};
use App\Http\Requests\{NewTaskRequest, GetParamsTasksRequest, PatchTaskRequest};
use App\Http\Resources\{TaskResource, TaskCollection};
use App\Trait\ResponseTrait;

class TasksController
{
  use ResponseTrait;

  public function index(GetParamsTasksRequest $params, int $projectId, ListProjectTasksUseCase $useCase): TaskCollection
  {
    $dto = ListTasksFilterDTO::fromArray($params->validated());

    $tasks = $useCase->execute($dto, $projectId);

    return new TaskCollection($tasks);
  }
  public function store(NewTaskRequest $req, int $projectId,  CreateTaskUseCase $useCase)
  {
    $dto = CreateTaskDTO::fromArray($projectId, $req->validated());
    $task = $useCase->execute($dto);

    return (new TaskResource($task))->response()->setStatusCode(201);
  }
  
  public function update(PatchTaskRequest $req, int $taskId, UpdateTaskStatusPriorityUseCase $useCase)
  {
    $dto = UpdateTaskDTO::fromArray($req->validated());

    $patchTask = $useCase->execute($taskId, $dto);

    return new TaskResource($patchTask);
  }

  public function destroy(int $taskId, DeleteTaskUseCase $useCase)
  {
    $taskDeleted = $useCase->execute($taskId);

    return $this->success('task deleted', 200);
  }
}
