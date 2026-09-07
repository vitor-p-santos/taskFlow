<?php

namespace App\Applications\Users\Exceptions;

use InvalidArgumentException;

class CredentialsException extends InvalidArgumentException
{
    public function __construct(string $message = "email ou senha invalidos", int $code = 400)
    {
        parent::__construct($message, $code);
    }
}
