<?php

namespace App\Domain\Projects\Enums;

enum ProjectStatus: string
{
  case ARCHIVED = 'archived';
  case ACTIVE = 'active';
}
