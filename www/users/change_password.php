<?php
require_once('../lib/lib.php');

$session = new Session();
$user = new User();
$current_user = $session->getCurrentUser();

if (!$session->isLoggedIn()) {
  die('You are not logged in');
}

if (Form::isSubmitted()) {
  $fields_to_check = ['old_password', 'password'];
  if (!Form::isAllSet($fields_to_check)) {
    die('Not all fields are set');
  }

  try { 
    $user->changePassword($current_user['id'], $_POST['old_password'], $_POST['password']);
    die('Password changed');
  }
  catch (Exception $e) {
    var_dump($e->getMessage());
    die('Something went wrong');
  }
}
?>
<form action="/users/change_password.php" method="post">
  <input type="password" name="old_password" placeholder="Old password" required>
  <input type="password" name="password" placeholder="New password" required>

  <input type="submit" name="submit" value="Change password">
</form>
