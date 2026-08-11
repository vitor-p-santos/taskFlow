<?php

namespace App\Actions;

use App\Interfaces\ActionInterface;
use App\Models\Task;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class NewAction implements ActionInterface
{
  public function __invoke(array $data): Task
  {
    return Task::create([
      'title' => $data['title'],
      'project_id' => $data['project_id'],
      'description' => $data['description'],
      'status' => $data['status'],
      'priority' => $data['priority'],
      'due_date' => Carbon::parse($data['due_date']),
    ]);
  }
}
