<?php
require_once('../lib/lib.php');

$session = new Session();

if ($session->isLoggedIn()) {
  // TODO: Show error or redirect
  die('You are already logged in');
}

if (Form::isSubmitted()) {
  // Check if we have everything we need
  $fields_to_check = ['email', 'password'];
  if (!Form::isAllSet($fields_to_check)) {
    // TODO: Show error
    die('Not all fields are set');
  }

  try {
    $session->login($_POST['email'], $_POST['password']);
    die('Logged in');
  }
  catch (Exception $e) {
    // TODO: Show error
    var_dump($e->getMessage());
    die('Something went wrong');
  }
}
?>
<form action="/users/login.php" method="post">
  <input type="email" name="email" placeholder="Email" required>
  <input type="password" name="password" placeholder="Password" required>

  <input type="submit" name="submit" value="Login">
</form>
