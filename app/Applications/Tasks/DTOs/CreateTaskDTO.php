<?php

namespace App\Applications\Tasks\DTOs;

use App\Domain\Tasks\Enums\PriorityTask;
use App\Domain\Tasks\Enums\StatusTask;

class CreateTaskDTO
{
  public function __construct(
    readonly int $projectId,
    readonly string $title,
    readonly string $description,
    readonly StatusTask $status,
    readonly PriorityTask $priority,
    readonly ?string $dueDate
  ) {}

  public static function fromArray(int $projectId, array $data): self
  {
    return new self(
      projectId: $projectId,
      title: $data['title'],
      description: $data['description'],
      status: StatusTask::from($data['status']),
      priority: PriorityTask::from($data['priority']),
      dueDate: $data['due_date']
    );
  }

  public function toArray(): array
  {
    return [
      'project_id'  => $this->projectId,
      'title'       => $this->title,
      'description' => $this->description,
      'status'      => $this->status->value,
      'priority'    => $this->priority->value,
      'due_date'    => $this->dueDate,
    ];
  }
}
