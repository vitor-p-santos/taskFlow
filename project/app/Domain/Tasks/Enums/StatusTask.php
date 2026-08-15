<?php

namespace App\Domain\Tasks\Enums;

enum StatusTask: string
{
  case TODO = 'todo';
  case iN_PROGRESS = 'in_progress';
  case DONE = 'done';
}
