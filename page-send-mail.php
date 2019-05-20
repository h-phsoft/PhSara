<?php

require_once $PH_RELATIVE_PATH . 'PhModules/securimage/securimage.php';

/*
  if we want to send attached
  $aAttach = array("filename" => '../assets/img/subscribe-bg.jpg');
  echo ph_SendEmail($aRecips, $subject, $message, $mailSettings, $aAttach);
 */

$from = 'website@sarashamma.com';
$name = ph_Post('cus_name');
$email = ph_Post('cus_email');
$subject = ph_Post('cus_subject');
$message = ph_Post('cus_message');
$captcha = ph_Post('captcha_code0');

if ($email != '') {
  if ($subject != '') {
    if ($message != '') {
      $securimage = new Securimage();
      if ($securimage->check($captcha) == true) {
        $aRecips = array(
            "FROM" => $from,
            "TO" => 'message@sarashamma.com',
            "CC" => "",
            "BCC" => ""
        );
        $mailSettings = array(
            "PH_SMTP_SERVER" => "mail.sarashamma.com",
            "PH_SMTP_SERVER_PORT" => "25",
            "PH_SMTP_SERVER_USERNAME" => "",
            "PH_SMTP_SERVER_PASSWORD" => "",
            "PH_SMTP_SERVER_SECURE" => ""
        );
        echo ph_SendEmail($aRecips, $subject, $message, $mailSettings);
        ph_ResetGets();
        ph_ResetPosts();
      }
    }
  }
}

include "page-main.php";
?>
