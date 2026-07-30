<?php

namespace App\Domain\Tasks\Enum;

enum PriorityTask: string
{
  case Low = 'low';
  case Medium = 'medium';
  case High = 'high';
}
