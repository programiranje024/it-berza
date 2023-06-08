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
  echo ('User id is required');
}

if ($user_id === $session->getCurrentUser()['id']) {
  echo ('You cannot unban yourself');
}

$unbanned_user = $user->getUserById($user_id);

if (!$unbanned_user) {
  echo ('User with this id does not exist');
}

if (!$unbanned_user['banned']) {
  echo ('User is not banned');
}

$user = $admin->unbanUser($user_id);

if (!$user) {
  echo ('User could not be unbanned');
}

include_once('../../partials/header.php');
?>
<a class="back" href="/admin/index.php">Back</a>
<h2>User has been unbanned</h2>
<?php
include_once('../../partials/footer.php');
?>
