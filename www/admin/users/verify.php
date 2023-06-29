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
    'message' => 'You cannot verify yourself'
  ]));
}

$unverified_user = $user->getUserById($user_id);

if (!$unverified_user) {
  die(json_encode([
    'message' => 'User does not exist'
  ]));
}

if ($unverified_user['verified']) {
  die(json_encode([
    'message' => 'User is already verified'
  ]));
}

$user = $admin->verifyUser($user_id);

if (!$user) {
  die (json_encode([
    'message' => 'Failed to verify user'
  ]));
}

die(json_encode([
  'message' => 'User verified successfully'
]));
