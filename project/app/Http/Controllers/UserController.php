<?php

namespace App\Http\Controllers;

use App\Applications\Projects\UseCases\GetStatisticUseCase;
use App\Applications\Users\UseCases\GetMeUseCase;

class UserController
{

  public function me(GetMeUseCase $useCase)
  {
    return $useCase->execute();
  }

  public function statistic(GetStatisticUseCase $useCase)
  {
    return $useCase->execute();
  }
}
