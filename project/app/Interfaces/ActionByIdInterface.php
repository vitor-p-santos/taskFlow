<?php

namespace App\Interfaces;

use App\Models\Task;

interface ActionByIdInterface
{
  public function __invoke(Task $task, array $data);
}
