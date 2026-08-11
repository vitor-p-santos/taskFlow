<?php

namespace App\Trait;

trait ResponseTrait
{
  public function success(string $message, int $statusCode = 200)
  {
    $response = [
      'success' => true,
      'message' => $message,

    ];

    return response()->json($response, $statusCode);
  }
  public function error(string $message, int $statusCode = 400)
  {
    $response = [
      'success' => false,
      'message' => $message,
    ];

    return response()->json($response, $statusCode);
  }
}
