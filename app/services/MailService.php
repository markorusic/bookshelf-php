<?php

namespace App\Services;

class MailService
{
  public static function send($config) {
    $email_from = 'marko.rusic.22.17@gmail.com';
    $to = $config['to'];
    $subject = $config['subject'];
    $message = $config['message'];
    
    $headers = 'From: '.$email_from."\r\n".
    'Reply-To: '.$email_from."\r\n" .
    'X-Mailer: PHP/' . phpversion();

    mail($to, $subject, $message, $headers);
  }
}
