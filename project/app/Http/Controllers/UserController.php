<?php

namespace App\Http\Controllers;

use App\Applications\Projects\UseCases\GetStatisticUseCase;
use App\Applications\Users\DTOs\CreateUserDto;
use App\Applications\Users\UseCases\{CreateUserUseCase, GetMeUseCase};
use App\Http\Requests\Auth\RegisterRequest;
use Illuminate\Http\JsonResponse;

class UserController extends Controller
{

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
  public function me(GetMeUseCase $useCase)
  {
    return $useCase->execute();
  }

  public function statistic(GetStatisticUseCase $useCase)
  {
    return $useCase->execute();
  }
}
