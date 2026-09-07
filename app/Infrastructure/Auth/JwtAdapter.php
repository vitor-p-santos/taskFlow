<?php

namespace App\Infrastructure\Auth;

use App\Applications\Auth\Ports\TokenGeneratorPort;
use App\Infrastructure\Database\Models\EloquentUser;
use Tymon\JWTAuth\JWTGuard;

class JwtAdapter implements TokenGeneratorPort
{
    public function getAuthenticatedUser()
    {
        return auth()->user();
    }

    public function generateTokens(EloquentUser $user): array
    {
        $token = auth()->login($user);

        return [
            'access_token' => $token,
            'expires_in'   => auth()->factory()->getTTL() * 60
        ];
    }

    public function logout(): bool
    {
        auth()->logout();
        return true;
    }

    public function refreshToken(): array
    {
        $newToken = auth()->refresh();

        return [
            'access_token' => $newToken,
            'expires_in'   => auth()->factory()->getTTL() * 60
        ];
    }
}
