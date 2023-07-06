<?php

class User {
  protected $db = null;
  protected $mailer = null;

  public function __construct() {
    $this->db = (new Db())->getInstance();
    $this->mailer = new Mailer();
  }

  public function getUserByEmail($email) {
    $stmt = $this->db->prepare("SELECT * FROM users WHERE email = ?");

    $stmt->execute([$email]);

    return $stmt->fetch();
  }

  public function getUserById($id) {
    $stmt = $this->db->prepare("SELECT * FROM users WHERE id = ?");

    $stmt->execute([$id]);

    $user = $stmt->fetch();

    if ($user['role'] == 'company') {
      $user['company'] = $this->getCompanyData($user['id']);
    }

    return $user;
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
    $token = $this->getVerificationToken($user_id);

    $this->mailer->send($data['email'], 'Verify your email', 'You have successfully registered. Please verify your email by clicking <a href="http://localhost/users/verify.php?token=' . $token['token'] . '">here</a>');

    return $this->getUserById($user_id);
  }

  public function changePassword($id, $old, $new) {
    $user = $this->getUserById($id);

    if (!$user) {
      throw new Exception("User with this id does not exist");
    }

    if (!password_verify($old, $user['password'])) {
      throw new Exception("Incorrect password");
    }

    $stmt = $this->db->prepare("UPDATE users SET password = ? WHERE id = ?");
    $stmt->execute([
      password_hash($new, PASSWORD_DEFAULT),
      $user['id']
    ]);
  }

  public function updatePassword($id, $pw) {
    $user = $this->getUserById($id);

    if (!$user) {
      throw new Exception("User with this id does not exist");
    }

    $stmt = $this->db->prepare("UPDATE users SET password = ? WHERE id = ?");

    $stmt->execute([
      password_hash($pw, PASSWORD_DEFAULT),
      $user['id']
    ]);
  }

  public function updateUser($user_id, $data) {
    $stmt = $this->db->prepare("UPDATE users SET name = ?, phone = ?, bio = ? WHERE id = ?");

    $stmt->execute([
      $data['name'],
      $data['phone'],
      $data['bio'],
      $user_id
    ]);

    if ($data['role'] === 'company') {
      $stmt = $this->db->prepare("UPDATE company_data SET name = ?, website = ?, location = ? WHERE user_id = ?");

      $stmt->execute([
        $data['company_name'],
        $data['company_website'],
        $data['company_address'],
        $user_id
      ]);
    }

    return $this->getUserById($user_id);
  }

  public function deleteUser($user_id) {
    $user = $this->getUserById($user_id);

    if (!$user) {
      throw new Exception("User with this id does not exist");
    }

    if ($user['role'] === 'company') {
      $stmt = $this->db->prepare("DELETE FROM company_data WHERE user_id = ?");
      $stmt->execute([$user_id]);
    }

    $stmt = $this->db->prepare("DELETE FROM verification_tokens WHERE user_id = ?");
    $stmt->execute([$user_id]);

    $stmt = $this->db->prepare("DELETE FROM users WHERE id = ?");
    $stmt->execute([$user_id]);
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

  public function getCompanyData($user_id) {
    $stmt = $this->db->prepare("SELECT name AS company_name, location AS company_address, website AS company_website, id AS company_data_id FROM company_data WHERE user_id = ?");

    $stmt->execute([$user_id]);

    return $stmt->fetch();
  }

  public function verifyUser($token) {
    $stmt = $this->db->prepare("SELECT * FROM verification_tokens WHERE token = ?");

    $stmt->execute([$token]);

    if ($stmt->rowCount() > 0) {
      $token = $stmt->fetch();

      $stmt = $this->db->prepare("UPDATE users SET verified = 1 WHERE id = ?");

      $stmt->execute([$token['user_id']]);

      $stmt = $this->db->prepare("DELETE FROM verification_tokens WHERE id = ?");

      $stmt->execute([$token['id']]);

      return true;
    }

    return false;
  }

  public function getAllUsers() {
    $stmt = $this->db->prepare("SELECT * FROM users");

    $stmt->execute();

    $users = $stmt->fetchAll();

    foreach ($users as $key => $user) {
      if ($user['role'] === 'company') {
        $users[$key]['company'] = $this->getCompanyData($user['id']);
      }
    }

    return $users;
  }

  private function getVerificationToken($user_id) {
    $stmt = $this->db->prepare("SELECT * FROM verification_tokens WHERE user_id = ?");

    $stmt->execute([$user_id]);

    if ($stmt->rowCount() > 0) {
      return $stmt->fetch();
    }

    $stmt = $this->db->prepare("INSERT INTO verification_tokens (user_id, token) VALUES (?, ?)");

    $token = bin2hex(random_bytes(32));
    $stmt->execute([$user_id, $token]);

    return $this->getVerificationToken($user_id);
  }

  public function requestPasswordChange($email) {
    $user = $this->getUserByEmail($email);
    if ($user) {
      $token = $this->createResetToken($user['id']);

      $this->mailer->send($email, 'Reset your password', "Click this link to reset your password: http://localhost/user/reset_password.php?token=$token");

      return true;
    }

    return false;
  }

  public function resetPassword($password, $token) {
    $stmt = $this->db->prepare('SELECT user_id FROM password_reset WHERE token = ?');
    $stmt->execute([$token]);
    $result = $stmt->fetch();
    if ($result) {
      $user_id = $result['user_id'];
      $this->updatePassword($user_id, $password);
      $this->deleteResetToken($token);
      return true;
    } else {
      return false;
    }
  }

  private function createResetToken($id) {
    $token = bin2hex(random_bytes(8));

    $query = "INSERT INTO password_reset (user_id, token) VALUES (:user_id, :token)";
    $statement = $this->db->prepare($query);
    $statement->bindValue(':user_id', $id);
    $statement->bindValue(':token', $token);
    $statement->execute();

    return $token;
  }

  private function deleteResetToken($token) {
    $query = "DELETE FROM password_reset WHERE token = :token";
    $statement = $this->db->prepare($query);
    $statement->bindValue(':token', $token);
    $statement->execute();
  }
}
