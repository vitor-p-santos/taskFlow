<?php

namespace App\Infrastructure\Sercurity;

use App\Domain\Users\Contracts\PasswordHasherInterface;
use Illuminate\Support\Facades\Hash;

class LaravelPasswordHasher implements PasswordHasherInterface 
{
    public function make(string $password): string
    {
        return Hash::make($password);
    }

    public function check(string $password, string $hashedPassword): bool
    {
        return Hash::check($password, $hashedPassword);
    }
}