<?php

namespace App\Core;
use App\Core\App;

class Validation {

  private static function parseRule($rawRule) {
    $rules = [];
    $arr = explode('|', $rawRule);
    foreach ($arr as $key => $value) {
      if ($value == 'required') {
        $rules['required'] = true;
      }
      if ($value == 'email') {
        $rules['pattern'] = '\S+@\S+\.\S+';
      }
      if (strpos($value, 'pattern:') === 0) {
        $rules['pattern'] =  substr($value, strlen('pattern:'));
      }
      if (strpos($value, 'same_as:') === 0) {
        $rules['same_as'] =  substr($value, strlen('same_as:'));
      }
      if (strpos($value, 'unique:') === 0) {
        $rules['unique'] =  substr($value, strlen('unique:'));
      }
    }
    return $rules;
  }

  public static function validate($parameters, $rules) {
    $errors = [];
    foreach ($rules as $key => $rawRule) {
      $value = array_key_exists($key, $parameters) ? $parameters[$key] : null;
      $error = self::validateParameter($key, $value, $rawRule, $parameters);
      if ($error) {
        $errors[$key] = $error;
      }
    }
    return $errors;
  }

  public static function validateParameter($key, $value, $rawRule, $values) {
    $rule = self::parseRule($rawRule);
    $errorMessage = "";
    if (array_key_exists('required', $rule) && !$value) {
      return "{$key} is required!";
    }
    if (array_key_exists('pattern', $rule) && !preg_match("/{$rule['pattern']}/", $value)) {
      return "Incorrect {$key} format!";
    }
    if (array_key_exists('same_as', $rule)) {
      $cmpKey = $rule['same_as'];
      if (
        isset($values[$cmpKey]) &&
        $values[$cmpKey] &&
        $values[$cmpKey] !== $value
      ) {
        return "{$key}'s value has to match {$cmpKey} value!";
      }
    }
    if (
      array_key_exists('unique', $rule) &&
      App::get('database')->exists($rule['unique'], [
        $key => $value
      ])
    ) {
      return "{$key} {$value} alerady exists!";
    }
    return null;
  }

}
