<?php include_once "../phmysql.php" ?>
<?php include_once "../phfn.php" ?>
<?php include_once "../cpfn.php" ?>
<?php

require_once 'securimage/securimage.php';

/*
  if we want to send attached
  $aAttach = array("filename" => '../assets/img/subscribe-bg.jpg');
  echo ph_SendEmail($aRecips, $subject, $message, $mailSettings, $aAttach);
 */

ph_PrepareGets();
ph_PreparePosts();

$from = 'website@sarashamma.com';
$name = ph_Post('cus_name');
$email = ph_Post('cus_email');
$subject = ph_Post('cus_subject');
$message = ph_Post('cus_message');
$captcha = ph_Post('captcha_code');
if ($email != '') {
  if ($subject != '') {
    if ($message != '') {
      $aRecips = array(
          "FROM" => $from,
          "TO" => 'message@sarashamma.com',
          "CC" => "",
          "BCC" => ""
      );
      $mailSettings = array(
          "PH_SMTP_SERVER" => "",
          "PH_SMTP_SERVER_PORT" => "25",
          "PH_SMTP_SERVER_USERNAME" => "",
          "PH_SMTP_SERVER_PASSWORD" => "",
          "PH_SMTP_SERVER_SECURE" => ""
      );
      $securimage = new Securimage();
      if ($securimage->check($captcha) == true) {
        echo ph_SendEmail($aRecips, $subject, $message, $mailSettings);
      }
    }
  }
}
die;
