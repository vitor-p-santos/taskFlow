<?php

namespace App\Exceptions;

use App\Trait\ResponseTrait;
use Exception;

class TaskNotFoundException extends Exception
{
    use ResponseTrait;
    public function render()
    {
        return $this->error('Content has already been deleted', 422);
    }
}
