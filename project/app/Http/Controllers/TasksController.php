<?php

namespace App\Http\Controllers;

use App\Domain\Projects\Services\CheckProjectService;
use App\Domain\Tasks\Requests\{NewTaskRequest, PatchTaskRequest};
use App\Domain\Tasks\Resources\TaskResource;
use App\Domain\Tasks\Services\CheckTaskService;
use App\Domain\Tasks\Services\TaskService;
use App\Trait\ResponseTrait;


class TasksController
{
  use ResponseTrait;

  protected CheckTaskService $checkTaskService;
  protected CheckProjectService $checkProjectService;
  protected TaskService $taskService;

  public function __construct(

    CheckTaskService $checkTaskService,
    CheckProjectService $checkProjectService,
    TaskService $taskService
  ) {
    $this->checkTaskService = $checkTaskService;
    $this->checkProjectService = $checkProjectService;
    $this->taskService = $taskService;
  }

  public function get(int $id)
  {
    $params = request()->only(['status', 'priority', 'due_date']);

    $this->checkProjectService->find($id);

    $data =  $this->taskService->all($id, $params);

    $taskResource = TaskResource::collection($data);

    return $this->success('tasks found', 200, $taskResource,    [
      'next_cursor'    => optional($data->nextCursor())->encode(),
      'next_page_url'  => $data->nextPageUrl(),
      'prev_cursor'    => optional($data->previousCursor())->encode(),
      'prev_page_url'  => $data->previousPageUrl(),
      'has_more'       => $data->hasMorePages(),
    ]);
  }
  public function store(NewTaskRequest $req, int $id)
  {
    $body = $req->validated();

    $this->checkProjectService->find($id);

    $body['project_id'] = $id;

    $data = $this->taskService->create($body);

    $taskResource = new TaskResource($data);

    return $this->success('task created', 201, $taskResource);
  }
  public function patch(PatchTaskRequest $req, int $id)
  {

    $dataToUpdate = array_filter($req->validated(), fn($value) => !empty($value));

    $find = $this->checkTaskService->findTask($id);

    $task = $this->taskService->patchField($find, $dataToUpdate);

    $taskResource = new TaskResource($task);

    return $this->success('task updated', 200, $taskResource);
  }
  public function delete(int $id)
  {
    $find = $this->checkTaskService->checkSoftDelete($id);

    $this->taskService->softDelete($find);

    return $this->success('task deleted', 200);
  }
}
