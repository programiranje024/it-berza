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
    header('Location: /users/profile.php');
  }
  catch (Exception $e) {
    echo ('Something went wrong');
  }
}

include_once('../partials/header.php');
?>
<a class="back" href="/index.php">Back</a>
<h2>Login</h2>
<form action="/users/login.php" method="post">
  <input type="email" name="email" placeholder="Email" required>
  <input type="password" name="password" placeholder="Password">

  <input type="submit" name="submit" value="Login">
  <input type="submit" name="submit" value="Forgot password">
</form>
<link rel="stylesheet" href="/css/form.css">
<?php
include_once('../partials/footer.php');
?>
