<?php

namespace App\Enums;

enum StatusTask: string
{
  case Todo = 'todo';
  case InProgress = 'in_progress';
  case Done = 'done';
}
