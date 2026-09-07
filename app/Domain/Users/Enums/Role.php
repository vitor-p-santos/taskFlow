<?php

namespace App\Domain\Users\Enums;

enum Role: string
{
  case ADMIN = 'admin';
  case USER = 'user';
}
