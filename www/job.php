<?php
require_once('lib/lib.php');

$session = new Session();
$jobs = new Jobs();

$job_id = $_GET['id'] ?? null;

if (!$job_id) {
  echo ('Please provide a job id.');
} else {
  $job = $jobs->getJob($_GET['id']);

  if (!$job) {
    echo ('Job not found.');
  }
}

include_once('partials/header.php');
?>
<a class="back" href="/index.php">Back</a>
<h2><?php echo $job['title']; ?></h2>
<p><?php echo $job['description']; ?></p>
<p><?php echo $job['category']['name']; ?></p>
<p><?php echo $job['company']['company_name']; ?></p>

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
