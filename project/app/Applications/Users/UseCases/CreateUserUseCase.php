<?php

namespace App\Applications\Users\UseCases;

use App\Applications\Users\DTOs\CreateUserDto;
use App\Domain\Users\Contracts\UserRepositoryInterface;
use App\Applications\Auth\Ports\TokenGeneratorPort;
use App\Domain\Users\Contracts\PasswordHasherInterface;
use App\Domain\Users\Entities\User;
use App\Domain\Users\Rules\EmailGuard;

class CreateUserUseCase
{
  public function __construct(
    private UserRepositoryInterface $userRepository,
    private TokenGeneratorPort $tokenGenerator,
    private PasswordHasherInterface $passwordHasher
  ) {}

  public function execute(CreateUserDto $dto): array
  {
    EmailGuard::check($dto->email);

    $passwordHash = $this->passwordHasher->make($dto->password);

    $user = new User(
      name: $dto->name,
      email: $dto->email,
      password: $passwordHash
    );

    $savedUser = $this->userRepository->save($user);

    return $this->tokenGenerator->generateTokens($savedUser);
  }
}
