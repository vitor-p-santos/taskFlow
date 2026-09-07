<?php

namespace App\Applications\Users\DTOs;

use App\Domain\Users\Enums\Role;

class LoginUserDto
{
  public function __construct(
    readonly string $email,
    readonly string $password,
  ) {}

  public static function fromArray(array $data): self{
    return new self(
      email: $data['email'],
      password: $data['password'],
    );
  }

  public function toArray(): array{
    return [
      'email' => $this->email,
      'password' => $this->password,
    ];
  }
}
