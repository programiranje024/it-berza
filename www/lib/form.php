<?php

class Form {
  public static function isSubmitted() {
    return isset($_POST['submit']);
  }

  public static function isAllSet($fields) {
    foreach ($fields as $field) {
      if (!isset($_POST[$field])) {
        return false;
      }
    }

    return true;
  }

  public static function isEmail($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL);
  }
}
