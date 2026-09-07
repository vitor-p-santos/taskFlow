<?php

namespace App\Domain\Projects\Entities;

use App\Domain\Projects\Enums\ProjectStatus;

class Project
{
  public function __construct(
    readonly string $userId,
    readonly string $name,
    readonly string $description,
    readonly ProjectStatus $status
  ) {} 

}
