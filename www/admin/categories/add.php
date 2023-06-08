<?php
require_once('../../lib/lib.php');

$session = new Session();

if (!$session->isRole('admin')) {
  die('You are not authorized to access this page.');
}

$category = new Category();

if (Form::isSubmitted()) {
  if (Form::isAllSet(['name'])) {
    $name = $_POST['name'];

    try {
      $category->createCategory($name);
      die('Category has been added');
    } catch (Exception $e) {
      die('Category could not be added');
    }
  } else {
    die('All fields are required');
  }
}
?>
<form action="/admin/categories/add.php" method="post">
  <input type="text" name="name" placeholder="Name">
  <input type="submit" name="submit" value="Add">
</form>
