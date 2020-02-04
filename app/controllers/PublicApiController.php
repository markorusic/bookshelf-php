<?php

namespace App\Controllers;

use App\Core\Http\Controller;
use App\Models\{Book, Category, User};

class PublicApiController extends Controller
{
    public function findBooks()
    {
      return json(Book::findAll());
    }

    public function findBook()
    {
      $this->validateQuery([
        'id' => 'required'
      ]);
      return json(Book::find($this->query['id']));
    }

    public function findCategories()
    {
      return json(Category::findAll());
    }

    public function updateUserActivity()
    {
      if (!auth()->check()) {
        return abort(401, "UNAUTHORIZED");
      }
      User::updateLastActivity(auth()->user()->id);
      return json([
        'message' => 'success'
      ]);
    }

    public function contact()
    {
      $this->validateBody([
        'senderName' => 'required|pattern:^[a-zA-Z ]+$',
        'senderEmail' => 'required|email',
        'senderSubject' => 'required|pattern:^[a-z]{5,70}$',
        'senderMessage' => 'required|pattern:^[a-z]{10,250}$'
      ]);
      return json([
        'message' => 'Success'
      ]);
    }

}
