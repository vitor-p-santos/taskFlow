<?php

namespace App\Interfaces;

use Illuminate\Database\Eloquent\Model;

interface RepositoryInterface{

public function get(int $id, array $data);
public function all();
public function find(int $id): Model|null;
}