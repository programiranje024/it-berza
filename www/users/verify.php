<?php
require_once('../lib/lib.php');

$session = new Session();
$user = new User();

if ($session->isLoggedIn()) {
  die('You are already logged in');
}

if (isset($_GET['token'])) {
  if ($user->verifyUser($_GET['token'])) {
    die('Email verified');
  }
  else {
    die('Email verification failed');
  }
}
