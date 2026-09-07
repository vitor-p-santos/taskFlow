<?php

namespace App\Applications\Users\Exceptions;

use Exception;

class UserNotFound extends Exception
{
    public function __construct(string $message = "email ou senha invalidos")
    {
        parent::__construct($message);
    }
}
