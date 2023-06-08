<?php
require_once('../lib/lib.php');

$session = new Session();

if ($session->isLoggedIn()) {
  echo ('You are already logged in');
}

if (Form::isSubmitted()) {
  // Check if we have everything we need
  $fields_to_check = ['email', 'password'];
  if (!Form::isAllSet($fields_to_check)) {
    echo ('Not all fields are set');
  }

  try {
    if ($_POST['submit'] === 'Forgot password') {
      $user = new User();
      $user->forgotPassword($_POST['email']);
      echo ('Email sent');
    }

    $session->login($_POST['email'], $_POST['password']);
    echo ('Logged in');
  }
  catch (Exception $e) {
    echo ('Something went wrong');
  }
}

include_once('../partials/header.php');
?>
<form action="/users/login.php" method="post">
  <input type="email" name="email" placeholder="Email" required>
  <input type="password" name="password" placeholder="Password">

  <input type="submit" name="submit" value="Login">
  <input type="submit" name="submit" value="Forgot password">
</form>
<?php
include_once('../partials/footer.php');
?>
