<?php
require_once('../lib/lib.php');
$session = new Session();

if (!$session->isLoggedIn()) {
  die('You are not logged in');
}

$session->logout();
die('Logged out');
