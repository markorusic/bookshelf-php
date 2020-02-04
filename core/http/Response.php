<?php

namespace App\Core\Http;

class Response
{
  /**
   * Returns JSON response.
   *
   * @param  array $data
   * @param  int $status
   */
  public static function json($data, $status = 200)
  {
      header('Content-type: application/json');
      http_response_code($status);
      echo json_encode($data, JSON_NUMERIC_CHECK);
      exit;
  }

  /**
   * Aborts request with error status code.
   *
   * @param  int $status
   * @param  string $message
   */

  public static function abort($status = 400, $message = null) {
    if ($status < 400) {
      throw new Exception("Cannot abort with response status {$status}, it has to be 400 or higher!");
    }
    return self::json(['message' => $message], $status);
  }
}
