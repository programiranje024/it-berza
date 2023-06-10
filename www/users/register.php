<?php
require_once('../lib/lib.php');
$session = new Session();
$all_ok = true;

if ($session->isLoggedIn()) {
  echo ('You are already logged in');
  $all_ok = false;
}

if (Form::isSubmitted() && $all_ok) {
  // Check if we have everything we need
  $fields_to_check = ['name', 'phone', 'email', 'password', 'role'];
  if (!Form::isAllSet($fields_to_check)) {
    echo ('Not all fields are set');
    $all_ok = false;
  }

  if ($_POST['role'] === 'company' && $all_ok) {
    $fields_to_check = ['company_name', 'company_address', 'company_website'];
    if (!Form::isAllSet($fields_to_check)) {
      echo ('Not all fields are set for company');
      $all_ok = false;
    }
  }

  // Check if email is valid
  if (!Form::isEmail($_POST['email']) && $all_ok) {
    echo ('Email is not valid');
    $all_ok = false;
  }

  if ($all_ok) {
    // Try to register user
    $user = new User();

    try {
      if ($_POST['role'] === 'company') {
        $user->registerCompany($_POST);
      }
      else {
        $user->registerUser($_POST);
      }
      echo ('User registered! Please check your email to activate your account');
    }
    catch (Exception $e) {
      echo ('Something went wrong');
    }
  }
}

include_once('../partials/header.php');
?>
<a class="back" href="/index.php">Back</a>
<h2>Register</h2>
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
<link rel="stylesheet" href="/css/form.css">
<?php
include_once('../partials/footer.php');
?>
