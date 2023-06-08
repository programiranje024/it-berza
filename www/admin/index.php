<?php
require_once('../lib/lib.php');

$session = new Session();
$user = new User();

if (!$session->isRole('admin')) {
  die('You are not authorized to access this page.');
}

$users = $user->getAllUsers();

$users = array_map(function($user) {
  unset($user['password']);
  if ($user['banned']) {
    $user['status'] = 'Banned';
  } else if ($user['verified']) {
    $user['status'] = 'Verified';
  } else {
    $user['status'] = 'Unverified';
  }

  return $user;
}, $users);

$users = array_filter($users, function($user) use ($session) {
  $current_user = $session->getCurrentUser();
  
  return $user['id'] !== $current_user['id'];
});
?>

<h2>Manage Users:</h2>
<table>
  <thead>
    <tr>
      <th>Name</th>
      <th>Email</th>
      <th>Phone</th>
      <th>Role</th>
      <th>Status</th>
      <th>Actions</th>
    </tr>
  </thead>
  <?php
    foreach ($users as $user) {
  ?>
    <tr>
      <td><?php echo $user['name']; ?></td>
      <td><?php echo $user['email']; ?></td>
      <td><?php echo $user['phone']; ?></td>
      <td><?php echo $user['role']; ?></td>
      <td><?php echo $user['status']; ?></td>
      <td>
        <a href="/admin/users/delete.php?id=<?php echo $user['id']; ?>">Delete</a>
        <?php if ($user['status'] === 'Unverified') { ?>
          <a href="/admin/users/verify.php?id=<?php echo $user['id']; ?>">Verify</a>
        <?php } ?>
        <?php if ($user['status'] === 'Verified') { ?>
          <a href="/admin/users/ban.php?id=<?php echo $user['id']; ?>">Ban</a>
        <?php } ?>
        <?php if ($user['status'] === 'Banned') { ?>
          <a href="/admin/users/unban.php?id=<?php echo $user['id']; ?>">Unban</a>
        <?php } ?>
      </td>
    </tr>
  <?php
    }
  ?>
</table>

