<?php

namespace App\Controllers;

use App\Core\Http\Controller;

class AdminController extends Controller {

  public function __construct() {
    parent::__construct();
    $this->roles = ['admin'];
    $this->redirectPath = 'admin/login';
  }

}
