<?php
require_once('../lib/lib.php');
$session = new Session();

if (!$session->isLoggedIn()) {
  echo ('You are not logged in');
}

$session->logout();
echo ('Logged out');

include_once('../partials/header.php');
include_once('../partials/footer.php');
