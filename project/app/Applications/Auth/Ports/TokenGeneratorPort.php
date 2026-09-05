<?php

namespace App\Applications\Auth\Ports;

use App\Infrastructure\Database\Models\EloquentUser;

interface TokenGeneratorPort
{
    public function getAuthenticatedUser();
    public function generateTokens(EloquentUser $user): array;

    public function logout();

  public function refreshToken(): array;  

}