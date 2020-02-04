<?php

namespace App\Controllers;

use App\Core\Http\Controller;
use App\Services\{LoggingService, MailService};

class PublicAuthController extends Controller
{

  public function __construct() {
    parent::__construct();
    $this->redirectPath = '';
  }

  public function canAccess($action) {
    $isLogoutAction = $action == 'logout';
    $isLoggedIn = auth()->check('customer');
    return !$isLoggedIn || $isLogoutAction;
  }

  public function loginPage()
  {
    LoggingService::trackPageVisit('Login');
    return view('public/login');
  }

  public function registerPage()
  {
    LoggingService::trackPageVisit('Register');
    return view('public/register');
  }

  public function login()
  {
    $this->validate($_POST, [
      'email' => 'required|email',
      'password' => 'required|pattern:^.{6,}$'
    ], 'redirect');
    if (auth()->attempt($_POST['email'], $_POST['password'], 'customer')) {
      errors()->clear();
      return redirect($this->redirectPath);
    }
    MailService::send([
      'to' => $email,
      'subject' => 'Failed login attempt',
      'message' => 'Failed login attempt'
    ]);
    return redirectBack();
  }
  
  public function register()
  {
    $this->validate($_POST, [
      'name' => 'required|pattern:^[a-zA-Z ]+$',
      'email' => 'required|email|unique:users',
      'password' => 'required|pattern:^.{6,}$',
      'confirmPassword' => 'required|pattern:^.{6,}$|same_as:password',
    ], 'redirect');
    try {
      $userId = $this->db->insert('users', [
        'email' => $_POST['email'],
        'password' => $_POST['password'],
        'name' => $_POST['name']
      ]);
      $user = $this->db->selectWhere('users', [
        'id' => $userId
      ])[0];
      if ($user && auth()->attempt($user->email, $user->password, 'customer')) {
        errors()->clear();
        return redirect($this->redirectPath);
      }
    } catch (\Throwable $th) {
      return redirectBack();
    }
  }

  public function logout()
  {
    auth()->logout();
    return redirectBack();
  }

}
