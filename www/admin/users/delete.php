<?php
require_once('../../lib/lib.php');

$session = new Session();

if (!$session->isRole('admin')) {
  die('You are not authorized to access this page.');
}

$user = new User();
$user_id = $_GET['id'] ?? null;

if (!$user_id) {
  die('User id is required');
}

if ($user_id === $session->getCurrentUser()['id']) {
  die('You cannot delete yourself');
}

try {
  $user->deleteUser($user_id);
  die('User has been deleted');
} catch (Exception $e) {
  die('User could not be deleted');
}
