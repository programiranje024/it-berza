<?php

class Message {
  private $db = null;
  private $user = null;

  public function __construct() {
    $this->db = (new Db())->getInstance();
    $this->user = new User();
  }

  public function getReceivers($sender_id) {
    $sql = 'SELECT DISTINCT receiver_id AS id FROM messages WHERE sender_id = :sender_id';
    $stmt = $this->db->prepare($sql);
    $stmt->execute([':sender_id' => $sender_id]);
    $receivers = $stmt->fetchAll();

    $sql = 'SELECT DISTINCT sender_id AS id FROM messages WHERE receiver_id = :receiver_id';
    $stmt = $this->db->prepare($sql);
    $stmt->execute([':receiver_id' => $sender_id]);
    $senders = $stmt->fetchAll();

    $all = array_merge($receivers, $senders);
    $all = array_unique($all, SORT_REGULAR);

    return array_map(function($item) {
      return $this->user->getUserById($item['id']);
    }, $all);
  }

  public function getConversation($id1, $id2) {
    $sql = 'SELECT * FROM messages WHERE (sender_id = :id1 AND receiver_id = :id2) OR (sender_id = :id2 AND receiver_id = :id1) ORDER BY created_at ASC';
    $stmt = $this->db->prepare($sql);
    $stmt->execute([':id1' => $id1, ':id2' => $id2]);
    $messages = $stmt->fetchAll();

    return $messages;
  }

  public function sendMessage($msg, $sender_id, $receiver_id) {
    $sql = "INSERT INTO messages (sender_id, receiver_id, message) VALUES (:sender_id, :receiver_id, :message)";

    $stmt = $this->db->prepare($sql);

    $stmt->execute([
      ':sender_id' => $sender_id,
      ':receiver_id' => $receiver_id,
      ':message' => $msg
    ]);

    return $this->getConversation($sender_id, $receiver_id);
  }
}

