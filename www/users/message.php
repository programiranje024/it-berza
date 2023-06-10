<?php
require_once('../lib/lib.php');

$session = new Session();
$message = new Message();
$user = new User();

$current_user = $session->getCurrentUser();

if (Form::isSubmitted()) {
  if (!Form::isAllSet(['receiver_id', 'message'])) {
    echo ('Invalid request');
  } else {
    $receiver_id = $_POST['receiver_id'];
    $msg = $_POST['message'];

    $message->sendMessage($msg, $current_user['id'], $receiver_id);
  }
}

$receivers = $message->getReceivers($current_user['id']);
$receiver_id = $_GET['id'] ?? null;
$receiver = empty($receiver_id) ? null : $user->getUserById($receiver_id);
$is_company = !is_null($receiver) && isset($receiver['company']['company_name']);
$messages = empty($receiver_id) ? [] : $message->getConversation($current_user['id'], $_GET['id']);

include_once('../partials/header.php');
?>
<a class="back" href="/users/profile.php">Back</a>
<h2>Messages <?php if ($receiver) {
  echo 'with ' . ($is_company ? $receiver['company']['company_name'] : $receiver['name']);
} ?></h2>
<nav id="receivers">
  <ul>
    <?php foreach ($receivers as $receiver) { ?>
    <li>
      <a href="/users/message.php?id=<?php echo $receiver['id']; ?>">
        <?php echo $receiver['name'] . (isset($receiver['company']) ? ' (' . $receiver['company']['company_name'] . ')' : ''); ?>
      </a>
    </li>
    <?php } ?>
  </ul>
</nav>
<div>
<?php if ($receiver_id) {?>
<div>
  <?php foreach ($messages as $message) { ?>
  <div class="message <?php echo $message['sender_id'] === $current_user['id'] ? 'sent' : 'received'; ?>">
    <p><?php echo $message['message']; ?></p>
    <p>
      <?php 
        if ($message['sender_id'] === $current_user['id']) {
          echo 'You';
        } else {
          echo $receiver['name'];
        }
        echo " at ";
        echo $message['created_at']; 
      ?>
    </p>
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
<link rel="stylesheet" href="/css/messages.css" />
<link rel="stylesheet" href="/css/form.css" />
<?php
include_once('../partials/footer.php');
?>
