<?php

namespace App\Domain\Projects\Actions;

use App\Interfaces\ActionInterface;
use App\Models\Project;
use Illuminate\Support\Facades\DB;

class  NewAction implements ActionInterface
{
  public function __invoke(array $data): Project
  {
    return DB::transaction(function () use ($data) {
      return Project::create([
        'name' => $data['name'],
        'description' => $data['description'],
        'status' => $data['status'],
      ]);
    });
  }
}
