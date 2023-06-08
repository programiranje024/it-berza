<?php
require_once('lib/lib.php');

$companies = (new User())->getAllUsers();
$companies = array_filter($companies, function($company) {
  return $company['role'] == 'company';
});
$categories = (new Category())->getAllCategories();

$company_id = $_GET['company_id'] ?? null;
$category_id = $_GET['category_id'] ?? null;

$jobs = new Jobs();
$ads = empty($category_id) ? $jobs->getAllJobs() : $jobs->getJobsByCategory($category_id);

if (!empty($company_id)) {
  $ads = array_merge($ads, $jobs->getJobsByCompany($company_id));
}

include_once('partials/header.php');
?>
<h2>IT Berza</h2>
<form action="/index.php" method="get" id="search">
  <select name="company_id">
    <option value="">All companies</option>
    <?php foreach ($companies as $company) { ?>
    <option value="<?php echo $company['id']; ?>"
      <?php if ($company_id == $company['id']) { echo 'selected'; } ?>
    ><?php echo $company['company']['company_name']; ?></option>
    <?php } ?>
  </select>

  <select name="category_id">
    <?php foreach ($categories as $category) { ?>
    <option value="">All categories</option>
    <option value="<?php echo $category['id']; ?>"
      <?php if ($category_id == $category['id']) { echo 'selected'; } ?>
    ><?php echo $category['name']; ?></option>
    <?php } ?>
  </select>

  <input type="submit" name='submit' value="Search" />
</form>

<div id="ads">
  <?php foreach ($ads as $ad) { ?>
  <div class="ad">
    <h2><?php echo $ad['title']; ?></h2>
    <p><?php echo $ad['description']; ?></p>
    <p><?php echo $ad['company']['company_name']; ?></p>
    <p><?php echo $ad['category']['name']; ?></p>
    <a href="/job.php?id=<?php echo $ad['id']; ?>">View</a>
  </div>
  <?php } ?>
</div>
<link rel="stylesheet" href="/css/form.css" />
<link rel="stylesheet" href="/css/search.css" />
<?php include_once('partials/footer.php'); ?>
