<?php
require_once('../lib/lib.php');

$session = new Session();
$user = new User();
$current_user = $session->getCurrentUser();

if (!$session->isLoggedIn()) {
  die('You are not logged in');
} else {
  if (Form::isSubmitted()) {
    $fields_to_check = ['old_password', 'password'];
    if (!Form::isAllSet($fields_to_check)) {
      echo ('Not all fields are set');
    } else {
      try { 
        $user->changePassword($current_user['id'], $_POST['old_password'], $_POST['password']);
        echo ('Password changed');
      }
      catch (Exception $e) {
        echo ('Something went wrong');
      }
    }
  }
}

include_once('../partials/header.php');
?>
<a class="back" href="/users/profile.php">Back</a>
<h2>Change password</h2>
<form action="/users/change_password.php" method="post">
  <input type="password" name="old_password" placeholder="Old password" required>
  <input type="password" name="password" placeholder="New password" required>

  <input type="submit" name="submit" value="Change password">
</form>
<link rel="stylesheet" href="/css/form.css">
<?php
include_once('../partials/footer.php');
?>
