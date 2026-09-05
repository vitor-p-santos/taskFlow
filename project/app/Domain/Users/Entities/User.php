<?php

namespace App\Domain\Users\Entities;

use App\Domain\Users\Enums\Role;

class User 
{
    public function __construct(
        private string $name,
        private string $email,
        private string $password,
        // private Role $role,
        private ?int $id = null,
    ) {}

    public function getId(): ?string
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    // public function getRole(): ?string
    // {
    //     return $this->role->value;
    // }
}