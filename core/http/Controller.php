<?php

namespace App\Core\Http;

use App\Core\{App, Validation, Auth};

class Controller {

  protected  $query;

  protected $body;

  protected $db;

  protected $roles;

  public $redirectPath;

  public function __construct() {
    $this->query = Request::queryParams();
    $this->body = Request::body();
    $this->db = App::get('database');
    $this->roles = ['*'];
    $this->redirectPath = config('auth.defaultRedirectPath');
  }

  public function canAccess($action) {
    $isPublic = in_array('*', $this->roles);
    $userCanAccess = auth()->check() && in_array(auth()->user()->role, $this->roles);
    return $isPublic || $userCanAccess;
  }
  
  protected function validate($parameters, $rules, $mode) {
    $errors = Validation::validate($parameters, $rules);
    if (count($errors) > 0) {
      if ($mode == 'json') {
        return json(compact('errors'), 400);
      }
      foreach ($errors as $key => $value) {
        errors()->set($key, $value);
      }
      redirectBack();
      exit;
    }
  }

  protected function validateQuery($rules, $mode = 'json') {
    return $this->validate($this->query, $rules, $mode);
  }

  protected function validateBody($rules, $mode = 'json') {
    return $this->validate($this->body, $rules, $mode);
  }

}
