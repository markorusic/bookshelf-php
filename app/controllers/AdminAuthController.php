<?php

namespace App\Controllers;

use App\Core\Http\Controller;

class AdminAuthController extends Controller
{

  public function __construct() {
    parent::__construct();
    $this->redirectPath = 'admin';
  }

  public function canAccess($action) {
    $isLogoutAction = $action == 'logout';
    $isLoggedIn = auth()->check('admin');
    return !$isLoggedIn || $isLogoutAction;
  }

  public function loginPage()
  {
    return view('admin/auth/login');
  }  

  public function login()
  {
    $this->validate($_POST, [
      'email' => 'required|email',
      'password' => 'required|pattern:^.{6,}$'
    ], 'redirect');
    if (auth()->attempt($_POST['email'], $_POST['password'], 'admin')) {
      errors()->clear();
      return redirect('admin');
    }
    return redirectBack();
  }

  public function logout()
  {
    auth()->logout();
    return redirectBack();
  }
}
