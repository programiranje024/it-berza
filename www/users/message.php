<?php
require_once('../lib/lib.php');

$session = new Session();
$message = new Message();
$user = new User();

$current_user = $session->getCurrentUser();

if (Form::isSubmitted()) {
  if (!Form::isAllSet(['receiver_id', 'message'])) {
    die('Invalid request');
  }

  $receiver_id = $_POST['receiver_id'];
  $msg = $_POST['message'];

  $message->sendMessage($msg, $current_user['id'], $receiver_id);
}

$receivers = $message->getReceivers($current_user['id']);
$receiver_id = $_GET['id'] ?? null;
$receiver = empty($receiver_id) ? null : $user->getUserById($receiver_id);
$is_company = !is_null($receiver) && isset($receiver['company']['company_name']);
$messages = empty($receiver_id) ? [] : $message->getConversation($current_user['id'], $_GET['id']);
?>

<h2>Messages <?php if ($receiver) {
  echo 'with ' . ($is_company ? $receiver['company']['company_name'] : $receiver['name']);
} ?></h2>
<nav>
  <ul>
    <?php foreach ($receivers as $receiver) { ?>
    <li>
      <a href="/users/message.php?id=<?php echo $receiver['id']; ?>">
        <?php echo $receiver['name'] . ($is_company ? ' (' . $receiver['company']['company_name'] . ')' : ''); ?>
      </a>
    </li>
    <?php } ?>
  </ul>
</nav>
<div>
<?php if ($receiver_id) {?>
<div>
  <?php foreach ($messages as $message) { ?>
  <div>
    <p><?php echo $message['message']; ?></p>
    <p><?php echo $message['created_at']; ?></p>
  </div>
  <?php } ?>
</div>
<div>
  <form action="/users/message.php<?php echo '?id=' . $receiver_id; ?>" method="post">
    <input type="hidden" name="receiver_id" value="<?php echo $receiver_id; ?>" />
    <textarea name="message"></textarea>
    <input type="submit" name="submit" value="Send" />
  </form>
</div>
<?php } ?>
</div>