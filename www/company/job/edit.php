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
  die('Please provide a job id.');
}

$job = $jobs->getJob($_GET['id']);

if (!$job) {
  die('Job not found.');
}

if (!$job['company_id'] == $company['id']) {
  die('You are not allowed to edit this job.');
}

if (Form::isSubmitted()) {
  if (!Form::isAllSet(['title', 'description', 'category_id'])) {
    echo ('Please fill in all the fields.');
  }
  else {
    try {
      $jobs->updateJob($job_id,
        [
          'title' => $_POST['title'],
          'description' => $_POST['description']
      ], $company['id'], $_POST['category_id']);

      echo ('Ad updated successfully.');
    }
    catch (PDOException $e) {
      echo ('Error while updating the ad.');
    }
  }
}

include_once('../../partials/header.php');
?>
<a class="back" href="/company/index.php">Back</a>
<h2>Edit job ad</h2>
<form action="/company/job/edit.php?id=<?php echo $job_id; ?>" method="post">
  <input type="text" name="title" placeholder="Title" value="<?php echo $job['title']; ?>" />
  <textarea name="description" placeholder="Description"><?php echo $job['description']; ?></textarea>
  <select name="category_id">
    <?php foreach ($categories as $category) { ?>
    <option value="<?php echo $category['id']; ?>" <?php 
      if ($category['id'] == $job['category_id']) {
        echo 'selected';
      }
    ?>><?php echo $category['name']; ?></option>
    <?php } ?>
  </select>

  <input type="submit" name='submit' value="Update job ad" />
</form>
<link rel="stylesheet" href="/css/form.css">
<?php
include_once('../../partials/footer.php');
?>
