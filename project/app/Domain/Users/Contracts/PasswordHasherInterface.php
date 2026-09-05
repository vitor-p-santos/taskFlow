<?php

namespace App\Domain\Users\Contracts;

interface PasswordHasherInterface 
{
    public function make(string $password): string;
    public function check(string $password, string $hashedPassword): bool;
}