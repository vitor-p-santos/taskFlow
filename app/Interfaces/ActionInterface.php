<?php

namespace App\Interfaces;

interface ActionInterface
{

  public function __invoke(array $data);
}
