<?php
require_once('../../lib/lib.php');

$session = new Session();

if (!$session->isRole('admin')) {
  die(json_encode([
    'message' => 'You are not authorized to access this page.'
  ]));
}

$admin = new Admin();
$user = new User();
$user_id = $_GET['id'] ?? null;

if (!$user_id) {
  die(json_encode([
    'message' => 'User id is required'
  ]));
}

if ($user_id === $session->getCurrentUser()['id']) {
  die(json_encode([
    'message' => 'You cannot unban yourself'
  ]));
}

$unbanned_user = $user->getUserById($user_id);

if (!$unbanned_user) {
  die(json_encode([
    'message' => 'User does not exist'
  ]));
}

if (!$unbanned_user['banned']) {
  die(json_encode([
    'message' => 'User is not banned'
  ]));
}

$user = $admin->unbanUser($user_id);

if (!$user) {
  die (json_encode([
    'message' => 'Failed to unban user'
  ]));
}

die(json_encode([
  'message' => 'User unbanned successfully'
]));
