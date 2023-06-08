<?php
require_once('../../lib/lib.php');

$session = new Session();

if (!$session->isRole('admin')) {
  die('You are not authorized to access this page.');
}

$admin = new Admin();
$user = new User();
$user_id = $_GET['id'] ?? null;

if (!$user_id) {
  die('User id is required');
}

if ($user_id === $session->getCurrentUser()['id']) {
  die('You cannot ban yourself');
}

$unbanned_user = $user->getUserById($user_id);

if (!$unbanned_user) {
  die('User with this id does not exist');
}

if ($unbanned_user['banned']) {
  die('User is already banned');
}

$user = $admin->banUser($user_id);

if (!$user) {
  die('User could not be banned');
}

die('User has been banned');