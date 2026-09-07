<?php

namespace App\Applications\Auth\UseCases;

use App\Applications\Auth\Ports\TokenGeneratorPort;

class LogoutUseCase
{
  public function __construct(private TokenGeneratorPort $tokenGenerator) {}

  public function execute(): void
  {
    $this->tokenGenerator->logout();
  }
}
