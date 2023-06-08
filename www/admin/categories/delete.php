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
  die('Category has been deleted');
} catch (Exception $e) {
  die('Category could not be deleted');
}
