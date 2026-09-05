<?php

namespace App\Applications\Auth\UseCases;

use App\Applications\Auth\Ports\TokenGeneratorPort;

class RefreshTokenUseCase
{
    public function __construct(private TokenGeneratorPort $tokenGenerator) {}

    public function execute(): array
    {
        return $this->tokenGenerator->refreshToken();
    }
}