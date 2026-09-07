<?php

namespace App\Domain\Tasks\Enums;

enum PriorityTask: string
{
  case Low = 'low';
  case Medium = 'medium';
  case High = 'high';
}
