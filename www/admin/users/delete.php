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
} catch (Exception $e) {
  echo ('User could not be deleted');
}

include_once('../../partials/header.php');
?>
<a class="back" href="/admin/index.php">Back</a>
<h2>User has been deleted</h2>
<?php
include_once('../../partials/footer.php');
?>
