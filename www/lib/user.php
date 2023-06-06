<?php

class User {
  protected $db = null;

  public function __construct() {
    $this->db = (new Db())->getInstance();
  }

  public function getUserByEmail($email) {
    $stmt = $this->db->prepare("SELECT * FROM users WHERE email = ?");

    $stmt->execute([$email]);

    return $stmt->fetch();
  }

  public function getUserById($id) {
    $stmt = $this->db->prepare("SELECT * FROM users WHERE id = ?");

    $stmt->execute([$id]);

    return $stmt->fetch();
  }

  public function registerUser($data) {
    if ($this->getUserByEmail($data['email'])) {
      throw new Exception("User with this email already exists");
    }

    $stmt = $this->db->prepare("INSERT INTO users (email, password, name, phone, bio, role) VALUES (?, ?, ?, ?, ?, ?)");

    $stmt->execute([
      $data['email'],
      password_hash($data['password'], PASSWORD_DEFAULT),
      $data['name'],
      $data['phone'],
      $data['bio'],
      $data['role']
    ]);

    $user_id = $this->db->lastInsertId();

    return $this->getUserById($user_id);
  }

  public function registerCompany($data) {
    $user = $this->registerUser($data);

    $stmt = $this->db->prepare("INSERT INTO company_data (user_id, name, website, location) VALUES (?, ?, ?, ?)");

    $stmt->execute([
      $user['id'],
      $data['company_name'],
      $data['company_website'],
      $data['company_address']
    ]);

    return $user;
  }
}
