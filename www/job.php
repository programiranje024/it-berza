<?php
require_once('lib/lib.php');

$session = new Session();
$jobs = new Jobs();
$user = new User();
$category = new Category();

$job_id = $_GET['id'] ?? null;

if (!$job_id) {
  die('Please provide a job id.');
} 

$job = $jobs->getJob($_GET['id']);

if (!$job) {
  die('Job not found.');
}

$category = $category->getCategoryById($job['category_id']);
$company = $user->getUserById($job['company_id']);

include_once('partials/header.php');
?>
<a class="back" href="/index.php">Back</a>
<h2><?php echo $job['title']; ?></h2>
<p><?php echo $company['company']['company_name']; ?></p>
<p><?php echo $category['name']; ?></p>
<p><?php echo $job['description']; ?></p>

<?php if ($session->isRole('admin')) { ?>
<a class="delete" href="/company/job/delete.php?id=<?php echo $job['id']; ?>">Delete</a>
<?php } ?>

<?php if ($session->isRole('company') && $job['company_id'] == $session->getCurrentUser()['id']) { ?>
<a class="edit" href="/company/job/edit.php?id=<?php echo $job['id']; ?>">Edit</a>
<a class="delete" href="/company/job/delete.php?id=<?php echo $job['id']; ?>">Delete</a>
<?php } ?>

<?php if ($session->isRole('user')) { ?>
<a class="apply" href="/users/message.php?id=<?php echo $job['company_id']; ?>">Apply</a>
<?php } ?>

<?php if (!$session->isLoggedIn()) { ?>
<a class="apply" href="/users/login.php">Login to apply</a>
<?php } ?>
<?php include_once('partials/footer.php'); ?>
