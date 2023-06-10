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
  die('You cannot verify yourself');
}

$unverified_user = $user->getUserById($user_id);

if (!$unverified_user) {
  die('User with this id does not exist');
}

if ($unverified_user['verified']) {
  die('User is already verified');
}

$user = $admin->verifyUser($user_id);

if (!$user) {
  echo ('User could not be verified');
}

include_once('../../partials/header.php');
?>
<a class="back" href="/admin/index.php">Back</a>
<h2>User has been verified</h2>
<?php
include_once('../../partials/footer.php');
?>
