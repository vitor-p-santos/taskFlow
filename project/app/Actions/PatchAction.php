<?php

namespace App\Actions;

use App\Interfaces\ActionByIdInterface;
use App\Models\Task;
use Illuminate\Support\Facades\DB;

class PatchAction implements ActionByIdInterface
{
  public function __invoke(Task $task, array $data): Task
  {
    $task->update($data);
    return $task->fresh();
  }
}
