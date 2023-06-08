<?php
require_once('../lib/lib.php');

$session = new Session();

if (!$session->isRole('company')) {
  die('You are not allowed to access this page.');
}

$company = $session->getCurrentUser();
$jobs = new Jobs();
$category = new Category();

$ads = $jobs->getJobsByCompany($company['id']);
$ads = array_map(function($ad) use ($category) {
  $ad['category'] = $category->getCategoryById($ad['category_id'])['name'];
  return $ad;
}, $ads);

include_once('../partials/header.php');
?>

<h2>Your Ads</h2>
<table>
  <thead>
    <tr>
      <th>Title</th>
      <th>Description</th>
      <th>Category</th>
      <th>Actions</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($ads as $ad) { ?>
    <tr>
      <td><?php echo $ad['title']; ?></td>
      <td><?php echo $ad['description']; ?></td>
      <td><?php echo $ad['category']; ?></td>
      <td>
        <a href="/company/job/edit.php?id=<?php echo $ad['id']; ?>">Edit</a>
        <a class="delete" href="/company/job/delete.php?id=<?php echo $ad['id']; ?>">Delete</a>
      </td>
    </tr>
    <?php } ?>
  </tbody>
</table>

<a class="add" href="/company/job/create.php">Create new ad</a>
<link rel="stylesheet" href="/css/admin.css" />
<?php
include_once('../partials/footer.php');
?>
