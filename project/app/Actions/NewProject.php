<?php

namespace App\Actions;

use App\Interfaces\ActionInterface;
use App\Models\Project;
use Illuminate\Support\Facades\DB;

class NewProject implements ActionInterface
{
  public function __invoke(array $data): Project
  {
      return Project::create([
        'name' => $data['name'],
        'description' => $data['description'],
        'status' => $data['status'],
      ]);
  }
}
