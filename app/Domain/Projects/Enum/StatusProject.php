<?php

namespace App\Domain\Projects\Enum;

enum StatusProject: string
{
  case Archived = 'archived';
  case Active = 'active';
}
