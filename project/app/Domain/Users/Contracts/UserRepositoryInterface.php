<?php

namespace App\Domain\Users\Contracts;

use App\Domain\Users\Entities\User;

Interface UserRepositoryInterface{
  public function get(int $id);
  public function findByEmail(string $email);
  public function save(User $user);
}