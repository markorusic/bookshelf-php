<?php

namespace App\Core\Database;

use App\Core\App;

abstract class Model {

  protected static $table;

  protected static $primaryKey = 'id';

  protected static function db() {
    return App::get('database');
  }

  public static function findAll() {
    try {
      return static::db()->selectAll(static::$table);
    } catch (\PDOExeption $e) {
      return abort(500, $e->getMessage());
    }
  }

  public static function findWhere($parameters) {
    try {
      return static::db()->selectWhere(static::$table, $parameters);
    } catch (\PDOExeption $e) {
      return abort(500, $e->getMessage());
    }
  }

  public static function findPage($parameters) {
    try {
      return static::db()->selectPage(static::$table, $parameters);
    } catch (\PDOExeption $e) {
      return abort(500, $e->getMessage());
    }
  }

  public static function find($id) {
    try {
      $records = static::db()->selectWhere(static::$table, [
        static::$primaryKey => $id
      ]);
      if (!count($records)) {
        return null;
      }
      return $records[0];
    } catch (\PDOExeption $e) {
      return abort(500, $e->getMessage());
    }
  }

  public static function create($parameters) {
    $now = date("Y-m-d H:i:s");
    $parameters['created_at'] = $now;
    $parameters['updated_at'] = $now;
    try {
      return static::db()->insert(static::$table, $parameters);
    } catch (\PDOExeption $e) {
      return abort(500, $e->getMessage());
    }
  }

  public static function update($id, $parameters) {
    $now = date("Y-m-d H:i:s");
    $parameters['updated_at'] = $now;
    try {
      return static::db()->update(static::$table, $parameters, compact('id'));
    } catch (\PDOExeption $e) {
      return abort(500, $e->getMessage());
    }
  }

  public static function delete($parameters) {
    try {
      return static::db()->deleteWhere(static::$table, $parameters);
    } catch (\PDOExeption $e) {
      return abort(500, $e->getMessage());
    }

  }

  public static function exists($parameters) {
    try {
      return static::db()->exists(static::$table, $parameters);
    } catch (\PDOExeption $e) {
      return abort(500, $e->getMessage());
    }
  }

}
