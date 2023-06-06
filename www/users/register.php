<?php
require_once('../lib/lib.php');
$session = new Session();

if ($session->isLoggedIn()) {
  // TODO: Show error or redirect
  die('You are already logged in');
}

if (Form::isSubmitted()) {
  // Check if we have everything we need
  $fields_to_check = ['name', 'phone', 'email', 'password', 'role'];
  if (!Form::isAllSet($fields_to_check)) {
    // TODO: Show error
    die('Not all fields are set');
  }

  if ($_POST['role'] === 'company') {
    $fields_to_check = ['company_name', 'company_address', 'company_website'];
    if (!Form::isAllSet($fields_to_check)) {
      // TODO: Show error
      die('Not all fields are set for company');
    }
  }

  // Check if email is valid
  if (!Form::isEmail($_POST['email'])) {
    // TODO: Show error
    die('Email is not valid');
  }

  // Try to register user
  $user = new User();

  try {
    if ($_POST['role'] === 'company') {
      $user->registerCompany($_POST);
    }
    else {
      $user->registerUser($_POST);
    }
    // TODO: Show success
    die('User registered');
  }
  catch (Exception $e) {
    // TODO: Show error
    var_dump($e->getMessage());
    die('Something went wrong');
  }
}
?>

<form action="/users/register.php" method="post">
  <input type="text" name="name" placeholder="Name" required>
  <input type="tel" name="phone" placeholder="Phone" required>
  <input type="email" name="email" placeholder="Email" required>
  <input type="password" name="password" placeholder="Password" required>

  <input type="text" name="company_name" placeholder="Company name">
  <input type="text" name="company_address" placeholder="Company address">
  <input type="url" name="company_website" placeholder="Company website">

  <textarea name="bio" placeholder="Bio"></textarea>

  <div class="radio-group">
    <input type="radio" name="role" value="company" onclick="setRole('company')">
    <label for="company">Company</label>
    <input type="radio" name="role" value="user" onclick="setRole('user')" checked>
    <label for="user">User</label>
  </div>

  <input type="submit" name="submit" value="Register">
</form>
<script src="/js/register.js"></script>
