<?php

namespace App\Applications\Users\DTOs;

use App\Domain\Users\Enums\Role;

class CreateUserDto
{
  public function __construct(
    readonly string $name,
    readonly string $email,
    readonly string $password,
    readonly string $confirmPassword,
    // readonly Role $role,
  ) {}

  public static function fromArray(array $data): self{
    return new self(
      name : $data['name'],
      email: $data['email'],
      password: $data['password'],
      confirmPassword: $data['password'],
      // role: Role::from($data['role'])
    );
  }

  public function toArray(): array{
    return [
      'name' => $this->name,
      'email' => $this->email,
      'password' => $this->password,
      // 'role' => $this->role->value,
    ];
  }
}
