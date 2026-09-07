<?php

namespace App\Domain\Users\Exceptions;

use InvalidArgumentException;

class InvalidEmailException extends InvalidArgumentException
{
  public function __construct(string $message = "O e-mail fornecido é invalido", int $code = 422)
  {

    parent::__construct($message, $code);
  }
}
