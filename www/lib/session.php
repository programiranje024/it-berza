<?php

session_start();

class Session {
  protected $user = null;

  public function __construct() {
    $this->user = new User();
  }

  public function isLoggedIn() {
    return isset($_SESSION['user_id']);
  }

  public function getCurrentUser() {
    if (isset($_SESSION['user_id'])) {
      $user = $this->user->getUserById($_SESSION['user_id']);
      if ($user) {
        if ($user['role'] === 'company') {
          $user = array_merge($user, $this->user->getCompanyData($user['id']));
        }

        return $user;
      }
    }

    return null;
  }

  public function isRole($role) {
    $user = $this->getCurrentUser();

    if ($user) {
      return $user['role'] === $role;
    }

    return false;
  }

  public function setCurrentUser($user) {
    $_SESSION['user_id'] = $user['id'];
  }

  public function login($email, $password) {
    $user = $this->user->getUserByEmail($email);

    if (!$user) {
      throw new Exception("User with this email does not exist");
    }

    if (!password_verify($password, $user['password'])) {
      throw new Exception("Incorrect password");
    }

    if (!$user['verified']) {
      throw new Exception("You need to verify your email");
    }

    if ($user['banned']) {
      throw new Exception("You are banned");
    }

    $this->setCurrentUser($user);

    return $user;
  }

  public function logout() {
    unset($_SESSION['user_id']);
  }
}
