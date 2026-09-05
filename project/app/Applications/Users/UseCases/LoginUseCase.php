<?php

namespace App\Applications\Users\UseCases;

use App\Applications\Users\DTOs\LoginUserDto;
use App\Domain\Users\Contracts\UserRepositoryInterface;
use App\Applications\Auth\Ports\TokenGeneratorPort;
use App\Domain\Users\Contracts\PasswordHasherInterface;
use Exception;

class LoginUseCase
{
  public function __construct(
    private UserRepositoryInterface $userRepository,
    private TokenGeneratorPort $tokenGenerator,
    private PasswordHasherInterface $passwordHasher
  ) {}

  public function execute(LoginUserDto $dto): array
  {
    $user = $this->userRepository->findByEmail($dto->email);

    if (!$user) {
      throw new Exception('erro');
    }

    $hasher = $this->passwordHasher->check(
      $dto->password,
      $user->password
    );

    if (!$hasher) {
      // throw new Exception('erro');
    }

    return $this->tokenGenerator->generateTokens($user);
  }
}
