<?php

namespace App\Shared\Contracts;

use Illuminate\Database\Eloquent\Model;

interface RepositoryInterface{

public function all();
public function find(int $id): Model|null;
}