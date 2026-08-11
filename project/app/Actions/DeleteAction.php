<?php

namespace App\Actions;

use App\Interfaces\ActionByIdInterface;
use App\Models\Task;
use Illuminate\Support\Facades\DB;

class DeleteAction implements ActionByIdInterface
{

  public function __invoke(Task $task, array $data = []): Task
  {
      if(!empty($data)){
        $task->update($data);
      }
      
      $task->delete();
      
      return $task->fresh();
  }
}
