<?php

namespace App\Shered\Contracts;

use App\Domain\Tasks\Models\Task;

interface ActionByIdInterface
{
  public function __invoke(Task $task, array $data);
}
