<?php
require_once('lib/lib.php');

$session = new Session();
$jobs = new Jobs();

$job_id = $_GET['id'] ?? null;

if (!$job_id) {
  echo ('Please provide a job id.');
}

$job = $jobs->getJob($_GET['id']);

if (!$job) {
  echo ('Job not found.');
}

include_once('partials/header.php');
?>
<h2><?php echo $job['title']; ?></h2>
<p><?php echo $job['description']; ?></p>
<p><?php echo $job['category']['name']; ?></p>
<p><?php echo $job['company']['company_name']; ?></p>

<?php if ($session->isRole('admin')) { ?>
<a href="/admin/job/delete.php?id=<?php echo $job['id']; ?>">Delete</a>
<?php } ?>

<?php if ($session->isRole('company') && $job['company_id'] == $session->getCurrentUser()['id']) { ?>
<a href="/company/job/edit.php?id=<?php echo $job['id']; ?>">Edit</a>
<a href="/company/job/delete.php?id=<?php echo $job['id']; ?>">Delete</a>
<?php } ?>

<?php if ($session->isRole('user')) { ?>
<a href="/users/message.php?id=<?php echo $job['company_id']; ?>">Apply</a>
<?php } ?>

<?php if (!$session->isLoggedIn()) { ?>
<a href="/users/login.php">Login to apply</a>
<?php } ?>
<?php include_once('partials/footer.php'); ?>
