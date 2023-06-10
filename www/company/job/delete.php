<?php
require_once('../../lib/lib.php');

$session = new Session();
$can_access = $session->isRole('admin') || $session->isRole('company');

if (!$can_access) {
  die('You are not authorized to access this page.');
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

$can_delete = $session->isRole('admin') || ($session->isRole('company') && $job['company_id'] == $company['id']);

if (!$can_delete) {
  die('You are not allowed to delete this job.');
}

try {
  $jobs->deleteJob($job_id);
}
catch (PDOException $e) {
  echo ('Error while deleting the job.');
}

$back_url = $session->isRole('admin') ? '/admin/index.php' : '/company/index.php';

include_once('../../partials/header.php');
?>
<h2>Ad deleted successfully</h2>
<a class="back" href="<?php echo $back_url ?>">Back</a>
<?php
include_once('../../partials/footer.php');
?>
