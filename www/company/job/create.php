<?php
require_once('../../lib/lib.php');

$session = new Session();

if (!$session->isRole('company')) {
  die('You are not allowed to access this page.');
}

$company = $session->getCurrentUser();
$jobs = new Jobs();
$category = new Category();

$categories = $category->getAllCategories();

if (Form::isSubmitted()) {
  if (!Form::isAllSet(['title', 'description', 'category_id'])) {
    die('Please fill in all the fields.');
  }

  try {
    $jobs->createJob([
      'title' => $_POST['title'],
      'description' => $_POST['description']
    ], $company['id'], $_POST['category_id']);

    die('Ad created successfully.');
  }
  catch (PDOException $e) {
    die('Error while creating the ad.');
  }
}
?>
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
