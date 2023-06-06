<?php
require_once('../lib/lib.php');

$session = new Session();

if (!$session->isLoggedIn()) {
  die('You are not logged in');
}

$user = $session->getCurrentUser();

if (Form::isSubmitted()) {
  $fields_to_check = ['name', 'phone', 'email', 'bio'];
  if (!Form::isAllSet($fields_to_check)) {
    die('Not all fields are set');
  }

  if ($user['role'] === 'company') {
    $fields_to_check = ['company_name', 'company_address', 'company_website'];
    if (!Form::isAllSet($fields_to_check)) {
      die('Not all fields are set for company');
    }
  }

  if (!Form::isEmail($_POST['email'])) {
    die('Email is not valid');
  }

  $_user = new User();
  $session->setCurrentUser($_user->updateUser($user['id'], $_POST));
  $user = $session->getCurrentUser();
}
?>
<form action="/users/profile.php" method="post">
  <input type="text" name="name" placeholder="Name" value="<?php echo $user['name']; ?>" required>
  <input type="tel" name="phone" placeholder="Phone" value="<?php echo $user['phone']; ?>" required>
  <input type="email" name="email" placeholder="Email" value="<?php echo $user['email']; ?>" readonly required>

  <?php if ($user['role'] === 'company'): ?>
    <input type="text" name="company_name" placeholder="Company name" value="<?php echo $user['company_name']; ?>" required>
    <input type="text" name="company_address" placeholder="Company address" value="<?php echo $user['company_address']; ?>" required>
    <input type="url" name="company_website" placeholder="Company website" value="<?php echo $user['company_website']; ?>" required>
  <?php endif; ?>

  <textarea name="bio" placeholder="Bio" required><?php echo $user['bio']; ?></textarea>

  <input type="submit" name="submit" value="Update">
</form>