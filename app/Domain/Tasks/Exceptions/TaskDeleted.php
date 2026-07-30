<?php

namespace App\Domain\Tasks\Exceptions;

use App\Trait\ResponseTrait;
use Exception;

class TaskDeleted extends Exception
{
    use ResponseTrait;
    public function render()
    {
        return $this->error('task has already been deleted', 410);
    }
}
