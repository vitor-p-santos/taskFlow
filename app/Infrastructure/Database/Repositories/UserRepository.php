<?php

namespace App\Infrastructure\Database\Repositories;

use App\Domain\Users\Contracts\UserRepositoryInterface;
use App\Domain\Users\Entities\User as DomainUser;
use App\Domain\Users\Enums\Role;
use App\Infrastructure\Database\Models\EloquentUser;

class UserRepository implements UserRepositoryInterface
{
  public function get(int $id) {}

  public function findByEmail(string $email)
  {
    $eloquentUser = EloquentUser::where('email', $email)->first();

    if (!$eloquentUser) {
      return null;
    }

    return $eloquentUser;
  }

  public function save(DomainUser $user)
  {
    $eloquentUser = EloquentUser::create([
      'name'     => $user->getName(),
      'email'    => $user->getEmail(),
      'password' => $user->getPassword(),
    ]);

    return $eloquentUser;
  }
}
