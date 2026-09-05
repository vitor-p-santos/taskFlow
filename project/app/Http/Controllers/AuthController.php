<?php

namespace App\Http\Controllers;

use App\Applications\Users\DTOs\{CreateUserDto, LoginUserDto};
use App\Applications\Users\UseCases\{GetMeUseCase, LoginUseCase, CreateUserUseCase};
use App\Applications\Auth\UseCases\{LogoutUseCase, RefreshTokenUseCase};
use App\Applications\Projects\UseCases\GetStatisticUseCase;
use App\Http\Requests\Auth\{LoginRequest, RegisterRequest};
use App\Trait\ResponseTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Cookie;

class AuthController
{
    use ResponseTrait;

    // Helper genérico para criar qualquer cookie HTTP-Only com segurança
    private function getCookie($name, $token)
    {
        return cookie(
            $name,
            $token,
             20160 * 60,
            '/',
            null,
            false, // true em produção com HTTPS
            true,  // HttpOnly
            false,
            'Lax'
        );
    }

    public function login(LoginRequest $req, LoginUseCase $useCase): JsonResponse
    {
        $dto = LoginUserDto::fromArray($req->validated());
        $result = $useCase->execute($dto);

        $accessCookie = $this->getCookie('access_token', $result['access_token']);

        return response()->json([
            'message' => 'Login efetuado com sucesso',
            'expires_in' => $result['expires_in']
        ])->cookie($accessCookie);
    }

    public function register(RegisterRequest $req, CreateUserUseCase $useCase): JsonResponse
    {
        $dto = CreateUserDto::fromArray($req->validated());
        $result = $useCase->execute($dto);

        $accessCookie = $this->getCookie('access_token', $result['access_token']);

        return response()->json([
            'message' => 'Usuário registrado',
            'expires_in' => $result['expires_in']
        ], 201)->cookie($accessCookie);
    }

    public function refresh(RefreshTokenUseCase $useCase): JsonResponse
    {
        $result = $useCase->execute(); 

        $accessCookie = $this->getCookie('access_token', $result['access_token']);

        return response()->json([
            'message' => 'Token renovado',
            'expires_in' => $result['expires_in']
        ])->cookie($accessCookie);
    }

    public function logout(LogoutUseCase $useCase): JsonResponse
    {
        $useCase->execute();

        // Deleta ambos os cookies do navegador
        $clearAccess = Cookie::forget('access_token');
        $clearRefresh = Cookie::forget('refresh_token');

        return response()->json(['message' => 'Successfully logged out'])
            ->withCookie($clearAccess)
            ->withCookie($clearRefresh);
    }

    public function me(GetMeUseCase $useCase)
    {
        return $useCase->execute();
    }

    public function statistic(GetStatisticUseCase $useCase)
    {
        return $useCase->execute();
    }
}