<?php
require_once('../../lib/lib.php');

$session = new Session();

if (!$session->isRole('admin')) {
  die('You are not authorized to access this page.');
}

$user = new User();
$user_id = $_GET['id'] ?? null;

if (!$user_id) {
  echo ('User id is required');
}

if ($user_id === $session->getCurrentUser()['id']) {
  echo ('You cannot delete yourself');
}

try {
  $user->deleteUser($user_id);
  echo ('User has been deleted');
} catch (Exception $e) {
  echo ('User could not be deleted');
}

include_once('../../partials/header.php');
include_once('../../partials/footer.php');
