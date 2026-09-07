<?php

namespace App\Domain\Users\Rules;

use App\Applications\Users\Exceptions\CredentialsException;
class EmailGuard
{
  static function check(string $email)
  {

    $conta = "/^[a-zA-Z0-9\._-]+@";

    $domino = "[a-zA-Z0-9\._-]+.";

    $extensao = "([a-zA-Z]{2,4})$/";

    $pattern = $conta . $domino . $extensao;

    if (!preg_match($pattern, $email)) {
      throw new CredentialsException();
    }
  }
}
