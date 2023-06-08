<?php

class Admin {
  private $db = null;
  private $user = null;

  public function __construct() {
    $this->db = (new Db())->getInstance();
    $this->user = new User();
  }

  public function verifyUser($user_id) {
    $stmt = $this->db->prepare("UPDATE users SET verified = 1 WHERE id = ?");

    $stmt->execute([$user_id]);

    return $this->user->getUserById($user_id);
  }

  public function banUser($user_id) {
    $stmt = $this->db->prepare("UPDATE users SET banned = 1 WHERE id = ?");

    $stmt->execute([$user_id]);

    return $this->user->getUserById($user_id);
  }

  public function unbanUser($user_id) {
    $stmt = $this->db->prepare("UPDATE users SET banned = 0 WHERE id = ?");

    $stmt->execute([$user_id]);

    return $this->user->getUserById($user_id);
  }
}
