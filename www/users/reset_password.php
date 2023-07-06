<?php
// require all libs
require_once('../lib/lib.php');

$session = new Session();

// form handler
if ($session->isLoggedIn()) {
    die('You are already logged in');
} else {
    if (Form::isSubmitted()) {
        // Check if we have everything we need
        $fields_to_check = ['token', 'password'];
        if (!Form::isAllSet($fields_to_check)) {
            echo ('Not all fields are set');
        } else {
            try {
                $user = new User();
                $user->resetPassword($_POST['password'], $_POST['token']);
                echo ('Password reset successfully');
            } catch (Exception $e) {
                echo ('Something went wrong');
            }
        }
    }
}

// include header
include_once('../partials/header.php');
?>
<div class="container">
  <form action="/users/reset_password.php" method="post">
    <input type="password" name="password" placeholder="Password" required>
    <?php
    if (isset($_GET['token'])) {
    ?>
    <input type="hidden" name="token" value="<?php echo $_GET['token']; ?>">
    <?php
    }
    ?>
    <input type="submit" name="submit" value="Reset Password"
    <?php
    if (!isset($_GET['token'])) {
      echo 'disabled';
    }
    ?>>
  </form>
</div>

<?php
// include footer
include_once('../partials/footer.php');
?>