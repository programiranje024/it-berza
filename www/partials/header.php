<?php
$session = new Session();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>IT Berza</title>
    <style>
      html, body {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
      }
    </style>
    <link rel="stylesheet" href="/css/header.css">
</head>
<body>
<nav id="main-nav">
  <ul>
    <li><a href="/index.php">Home</a></li>
    <?php if ($session->isRole('admin')) { ?>
    <li><a href="/admin/index.php">Admin</a></li>
    <?php } ?>
    <?php if ($session->isRole('company')) { ?>
    <li><a href="/company/index.php">Company</a></li>
    <?php } ?>
    <?php if ($session->isLoggedIn()) { ?>
    <li><a href="/users/profile.php">Profile</a></li>
    <li><a href="/users/message.php">Messages</a></li>
    <li><a href="/users/logout.php">Logout</a></li>
    <?php } else { ?>
    <li><a href="/users/login.php">Login</a></li>
    <li><a href="/users/register.php">Register</a></li>
    <?php } ?>
  </ul>
</nav>
<div>
