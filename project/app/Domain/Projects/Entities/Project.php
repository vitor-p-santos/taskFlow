<?php

namespace App\Domain\Projects\Entities;

use App\Domain\Projects\Enums\ProjectStatus;

class Project
{
  public function __construct(
    readonly int $userId,
    readonly string $name,
    readonly string $description,
    readonly ProjectStatus $status
  ) {} 

}
