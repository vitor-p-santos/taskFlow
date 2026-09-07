<?php

namespace App\Applications\Users\UseCases;

use App\Applications\Users\DTOs\LoginUserDto;
use App\Domain\Users\Contracts\UserRepositoryInterface;
use App\Applications\Auth\Ports\TokenGeneratorPort;
use App\Applications\Users\Exceptions\CredentialsException;
use App\Domain\Users\Contracts\PasswordHasherInterface;
use App\Domain\Users\Rules\EmailGuard;

class LoginUseCase
{
  public function __construct(
    private UserRepositoryInterface $userRepository,
    private TokenGeneratorPort $tokenGenerator,
    private PasswordHasherInterface $passwordHasher
  ) {}

  public function execute(LoginUserDto $dto): array
  {
    EmailGuard::check($dto->email);
    $user = $this->userRepository->findByEmail($dto->email);
  
    if (!$user) {

      throw new CredentialsException();
    }

    $hasher = $this->passwordHasher->check(
      $dto->password,
      $user->password
    );

    if (!$hasher) {
      throw new CredentialsException();
    }

    return $this->tokenGenerator->generateTokens($user);
  }
}
