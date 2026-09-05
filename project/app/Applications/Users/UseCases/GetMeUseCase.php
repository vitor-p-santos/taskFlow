<?php

namespace App\Applications\Users\UseCases;

use App\Applications\Auth\Ports\TokenGeneratorPort;
use App\Domain\Users\Contracts\UserRepositoryInterface;

class GetMeUseCase
{
  public function __construct(
    private readonly TokenGeneratorPort $tokenGenerator,
    private readonly UserRepositoryInterface $userRepository
  ) {}

  public function execute(): object
  {
    $user =$this->tokenGenerator->getAuthenticatedUser();

    return $this->userRepository->findByEmail($user->email); 
  }
}
