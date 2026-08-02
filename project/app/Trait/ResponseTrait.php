<?php

namespace App\Trait;

trait ResponseTrait
{
  public function success(string $message, int $statusCode = 200, $data = null, array $meta = [])
  {
    $response = [
      'success' => true,
      'message' => $message,
      'meta' => $meta,
    ];

    if (!empty($data)) {
      $response['data'] = $data;
    }

    return response()->json($response, $statusCode);
  }
  public function error(string $message, int $statusCode = 400, $data = null)
  {
    $response = [
      'success' => false,
      'message' => $message,
    ];

    if (!empty($data)) {
      $response['data'] = $data;
    }

    return response()->json($response, $statusCode);
  }
}
