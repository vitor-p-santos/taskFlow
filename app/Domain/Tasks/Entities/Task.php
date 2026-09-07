<?php

namespace App\Domain\Tasks\Entities;

use App\Domain\Tasks\Enums\PriorityTask;
use App\Domain\Tasks\Enums\StatusTask;

class Task
{
  public function __construct(
    readonly int $projectId,
    readonly string $title,
    readonly string $description,
    readonly StatusTask $status,
    readonly PriorityTask $priority,
    readonly string $dueDate,
  ) {}
}
