<?php

namespace App\Models;

use App\Core\Database\Model;

class Book extends Model {

  protected static $table = 'books';

  public static function find($id) {
    $book = parent::find($id);
    if ($book) {
      $book->category = Category::find($book->category_id);
    }
    return $book;
  }

  public static function findFeatured() {
    return self::findWhere([
      'featured' => true
    ]);
  }
  
}
