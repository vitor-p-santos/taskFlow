<?php

namespace App\Shered\Contracts;

interface ActionInterface
{

  public function __invoke(array $data);
}
