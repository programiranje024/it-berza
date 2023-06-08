<?php
require_once('../../lib/lib.php');

$session = new Session();

if (!$session->isRole('company')) {
  die('You are not authorized to access this page.');
}

$job_id = $_GET['id'] ?? null;
$company = $session->getCurrentUser();
$jobs = new Jobs();
$category = new Category();

$categories = $category->getAllCategories();

if (!$job_id) {
  echo ('Please provide a job id.');
}

$job = $jobs->getJob($_GET['id']);

if (!$job) {
  echo ('Job not found.');
}

if (!$job['company_id'] == $company['id']) {
  echo ('You are not allowed to delete this job.');
}

try {
  $jobs->deleteJob($job_id);
  echo ('Job deleted successfully.');
}
catch (PDOException $e) {
  echo ('Error while deleting the job.');
}

include_once('../../partials/header.php');
include_once('../../partials/footer.php');
?>
