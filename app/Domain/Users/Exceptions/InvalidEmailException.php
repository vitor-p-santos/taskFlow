<?php

namespace App\Domain\Users\Exceptions;

use InvalidArgumentException;

class InvalidEmailException extends InvalidArgumentException
{
  public function __construct(string $message = "O e-mail fornecido é invalido", int $code = 400)
  {

    parent::__construct($message, $code);
  }
}
