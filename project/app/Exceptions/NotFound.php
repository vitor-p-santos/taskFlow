<?php

namespace App\Exceptions;

use App\Trait\ResponseTrait;
use Exception;

class NotFound extends Exception
{
    use ResponseTrait;

    protected $message;
    public function __construct(string $message = 'not found') {
        $this->message = $message;
    }
    public function render()
    {
        return $this->error($this->message, 404);
    }
}
