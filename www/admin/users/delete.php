<?php
require_once('../../lib/lib.php');

$session = new Session();

if (!$session->isRole('admin')) {
  die(json_encode([
    'message' => 'You are not authorized to access this page.'
  ]));
}

$user = new User();
$user_id = $_GET['id'] ?? null;

if (!$user_id) {
  die(json_encode([
    'message' => 'User id is required'
  ]));
}

if ($user_id === $session->getCurrentUser()['id']) {
  die(json_encode([
    'message' => 'You cannot delete yourself'
  ]));
}


try {
  $user->deleteUser($user_id);
  die(json_encode([
    'message' => 'User deleted successfully'
  ]));
} catch (Exception $e) {
  die(json_encode([
    'message' => 'Failed to delete user'
  ]));
}
