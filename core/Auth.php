<?php

namespace App\Core;

use App\Models\User;

class Auth {

  protected static $instance = null;

  public static function getInstance()
  {
    if (!isset(static::$instance)) {
      static::$instance = new static;
    }
    return static::$instance;
  }

  private function __construct() {}

  public function check($role = null) {
    $hasUserData = isset($_SESSION['userData']);
    if (!$hasUserData) {
      return false;
    }
    if (is_null($role)) {
      return true;
    }
    return $this->user()->role == $role;
  }

  public function user() {
    if (!array_key_exists('userData', $_SESSION)) {
      return null;
    }
    return $_SESSION['userData'];
  }

  public function attempt($email, $password, $role = null) {
    $db = App::get('database');
    try {
      $users = $db->selectWhere('users', compact('email', 'password'));
      if (
        count($users) == 1 &&
        $users[0]->password == $password &&
        !$role || (isset($users[0]) && $role == $users[0]->role)
      ) {
        $_SESSION['userData'] = $users[0];
        User::updateLastActivity(auth()->user()->id);
        return true;
      }
    } catch (\PDOExeption $e) {}
    errors()->set('auth_error', 'Wrong credentials.');
    return false;
  }

  public function logout() {
    unset($_SESSION['userData']);
  }

}
