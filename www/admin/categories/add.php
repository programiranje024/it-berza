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
      echo ('Category has been added');
    } catch (Exception $e) {
      echo ('Category could not be added');
    }
  } else {
    echo ('All fields are required');
  }
}

include_once('../../partials/header.php');
?>
<a class="back" href="/admin/index.php">Back</a>
<h2>Add Category</h2>
<form action="/admin/categories/add.php" method="post">
  <input type="text" name="name" placeholder="Name">
  <input type="submit" name="submit" value="Add">
</form>
<link rel="stylesheet" href="/css/form.css">
<?php
include_once('../../partials/footer.php');
?>
