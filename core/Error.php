<?php

namespace App\Core;

class Error {

  protected static $instance = null;

  protected static function updateErrorsAge()
  {
    if (isset($_SESSION['errors_age'])) {
      foreach ($_SESSION['errors_age'] as $key => $value) {
        $_SESSION['errors_age'][$key]++;
      }
    }
  }

  protected static function clearOutdated()
  {
    if (isset($_SESSION['errors']) && isset($_SESSION['errors_age'])) {
      foreach ($_SESSION['errors'] as $key => $value) {
        if (
          isset($_SESSION['errors'][$key]) &&
          isset($_SESSION['errors_age'][$key]) &&
          $_SESSION['errors_age'][$key] > 1
        ) {
          unset($_SESSION['errors'][$key]);
          unset($_SESSION['errors_age'][$key]);
        }
      }
    }
  }

  public static function getInstance()
  {
    if (!isset(static::$instance)) {
      static::updateErrorsAge();
      static::clearOutdated();
      static::$instance = new static;
    }
    return static::$instance;
  }

  private function __construct() {}

  public function getAll()
  {
    if (!isset($_SESSION['errors'])) {
      return [];
    }
    return $_SESSION['errors'];
  }

  public function set($key, $value) {
    if (isset($_SESSION['errors'])) {
      $_SESSION['errors'][$key] = $value;
      $_SESSION['errors_age'][$key] = 0;
    } else {
      $_SESSION['errors'] = [ $key => $value ];
      $_SESSION['errors_age'] = [ $key => 0 ];
    }
  }
  public function has($error) {
    return isset($_SESSION['errors'][$error]);
  }
  public function get($error) {
    if (!$this->has($error)) {
      return null;
    }
    return $_SESSION['errors'][$error];
  }
  public function clear() {
    unset($_SESSION['errors']);
  }
}
