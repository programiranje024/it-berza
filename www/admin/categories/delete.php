<?php
require_once('../../lib/lib.php');

$session = new Session();

if (!$session->isRole('admin')) {
  die('You are not authorized to access this page.');
}

$category = new Category();
$category_id = $_GET['id'] ?? null;

if (!$category_id) {
  die('Category id is required');
}

try {
  $category->deleteCategory($category_id);
} catch (Exception $e) {
  echo ('Category could not be deleted');
}

include_once('../../partials/header.php');
?>
<a class="back" href="/admin/index.php">Back</a>
<h2>Category has been deleted</h2>
<?php
include_once('../../partials/footer.php');
?>
