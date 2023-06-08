<?php
require_once('../lib/lib.php');
$session = new Session();

if (!$session->isLoggedIn()) {
  echo ('You are not logged in');
}

$session->logout();

include_once('../partials/header.php');
?>
<h2>You are logged out</h2>
<?php
include_once('../partials/footer.php');
?>
