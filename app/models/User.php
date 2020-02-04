<?php

namespace App\Models;

use App\Core\Database\Model;

class User extends Model {

  protected static $table = 'users';

  public static function updateLastActivity($userId)
  {
    $last_activity = date('Y-m-d H:i:s');
    return parent::update($userId, compact('last_activity'));
  }

  public static function findActive()
  {
    $query = "select *, null as password from users where last_activity > DATE_SUB(NOW(), INTERVAL 60 SECOND) order by role";
    $stmt = parent::db()->pdo->prepare($query);
    $stmt->execute();
    return $stmt->fetchAll(\PDO::FETCH_CLASS);
  }
  
}
