<?php

namespace App\Interfaces;

use Illuminate\Database\Eloquent\Model;

interface RepositoryInterface{

public function get(int $id, array $data);
public function all(array $filter);
public function find(int $id): Model|null;
}