<?php

class Mailer {
  public function __construct() {
    ini_set("sendmail_path", "/usr/sbin/sendmail -t mailhog:1025");
  }

  public function send($to, $subject, $message) {
    $headers = "From: admin@itberza.dev" . "\r\n" .
      "Reply-To: admin@itberza.dev" . "\r\n" .
      "X-Mailer: PHP/" . phpversion();

    return mail($to, $subject, $message, $headers);
  }
}
