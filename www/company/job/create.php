<?php
require_once('../../lib/lib.php');

$session = new Session();

if (!$session->isRole('company')) {
  die('You are not authorized to access this page.');
}

$company = $session->getCurrentUser();
$jobs = new Jobs();
$category = new Category();

$categories = $category->getAllCategories();

if (Form::isSubmitted()) {
  if (!Form::isAllSet(['title', 'description', 'category_id'])) {
    echo ('Please fill in all the fields.');
  }
  else {
    try {
      $jobs->createJob([
        'title' => $_POST['title'],
        'description' => $_POST['description']
      ], $company['id'], $_POST['category_id']);

      echo ('Ad created successfully.');
    }
    catch (PDOException $e) {
      echo ('Error while creating the ad.');
    }
  }
}

include_once('../../partials/header.php');
?>
<a class="back" href="/company/index.php">Back</a>
<h2>Create job ad</h2>
<form action="/company/job/create.php" method="post">
  <input type="text" name="title" placeholder="Title" />
  <textarea name="description" placeholder="Description"></textarea>
  <select name="category_id">
    <?php foreach ($categories as $category) { ?>
    <option value="<?php echo $category['id']; ?>"><?php echo $category['name']; ?></option>
    <?php } ?>
  </select>

  <input type="submit" name='submit' value="Post job ad" />
</form>
<link rel="stylesheet" href="/css/form.css">
<?php
include_once('../../partials/footer.php');
?>
