<?php

namespace App\Service;

use App\Exceptions\ContentDeleted;
use App\Exceptions\NotFound;
use App\Interfaces\RepositoryInterface;

class CheckService
{
  public function softDeleted(RepositoryInterface $repository, int $id)
  {
    $find = $repository->find($id);

    if (!$find) {
      throw new NotFound();
    }

    if ($find->trashed()) {
      throw new ContentDeleted();
    }

    return $find;
  }
  public function exist(RepositoryInterface $repository, int $id)
  {
    $find = $repository->find($id);

    if (!$find) {
      throw new NotFound();
    }

    return $find;
  }
}
