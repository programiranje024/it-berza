<?php
$session = new Session();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IT Berza</title>
    <style>
    @import url('https://bootswatch.com/5/slate/bootstrap.min.css');
    @import url('https://fonts.googleapis.com/css2?family=Roboto:wght@100;300;400;500;700;900&display=swap');
    </style>
    <style>
      html, body {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: 'Roboto', sans-serif;
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
