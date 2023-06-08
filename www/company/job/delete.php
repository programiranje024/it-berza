<?php
require_once('../../lib/lib.php');

$session = new Session();

if (!$session->isRole('company')) {
  die('You are not allowed to access this page.');
}

$job_id = $_GET['id'] ?? null;
$company = $session->getCurrentUser();
$jobs = new Jobs();
$category = new Category();

$categories = $category->getAllCategories();

if (!$job_id) {
  die('Please provide a job id.');
}

$job = $jobs->getJob($_GET['id']);

if (!$job) {
  die('Job not found.');
}

if (!$job['company_id'] == $company['id']) {
  die('You are not allowed to delete this job.');
}

try {
  $jobs->deleteJob($job_id);
  die('Job deleted successfully.');
}
catch (PDOException $e) {
  die('Error while deleting the job.');
}
?>
