<?php
require_once('../lib/lib.php');
$session = new Session();
$logged_in = $session->isLoggedIn();

if ($logged_in) {
  $session->logout();
}

include_once('../partials/header.php');
?>
<h2>You are <?php echo $logged_in ? '' : ' already ' ?> logged out</h2>
<?php
include_once('../partials/footer.php');
?>
