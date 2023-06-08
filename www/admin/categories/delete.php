<?php
require_once('../../lib/lib.php');

$session = new Session();

if (!$session->isRole('admin')) {
  die('You are not authorized to access this page.');
}

$category = new Category();
$category_id = $_GET['id'] ?? null;

if (!$category_id) {
  echo ('Category id is required');
}

try {
  $category->deleteCategory($category_id);
  echo ('Category has been deleted');
} catch (Exception $e) {
  echo ('Category could not be deleted');
}

include_once('../../partials/header.php');
include_once('../../partials/footer.php');
