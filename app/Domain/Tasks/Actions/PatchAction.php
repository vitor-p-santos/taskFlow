<?php

namespace App\Domain\Tasks\Actions;

use App\Interfaces\ActionByIdInterface;
use App\Models\Task;
use Illuminate\Support\Facades\DB;

class PatchAction implements ActionByIdInterface
{
  public function __invoke(Task $task, array $data): Task
  {
    return DB::transaction(function () use ($task, $data) {

      $task->update($data);
      return $task->fresh();
    });
  }
}
