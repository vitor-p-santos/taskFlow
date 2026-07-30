<?php

namespace App\Domain\Tasks\Enum;

enum StatusTask: string
{
  case Todo = 'todo';
  case InProgress = 'in_progress';
  case Done = 'done';
}
