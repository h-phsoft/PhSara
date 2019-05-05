<?php include_once "../phmysql.php" ?>
<?php include_once "../phfn.php" ?>
<?php include_once "../cpfn.php" ?>
<?php

// Prepare Request variables
ph_PrepareGets();
ph_PreparePosts();

$name = ph_Post('cus_name');
$from = ph_Post('cus_email');
$subject = ph_Post('cus_subject');
$message = ph_Post('cus_message');
if ($from == '') {
  $from = 'info@nazhaco.com';
}
if ($subject == '') {
  $subject = 'no subject';
}
if ($message == '') {
  $message = 'no message';
}
$aAttach = array("filename" => '../assets/img/subscribe-bg.jpg');
$aRecips = array(
    "FROM" => $from,
    "TO" => 'h.mahmoud@nscc-me.com',
    "CC" => "",
    "BCC" => ""
);
$mailSettings = array(
    "PH_SMTP_SERVER" => "email.e-lcom.sy",
    "PH_SMTP_SERVER_PORT" => "25",
    "PH_SMTP_SERVER_USERNAME" => "h.mahmoud@e-lcom.sy",
    "PH_SMTP_SERVER_PASSWORD" => "123456789",
    "PH_SMTP_SERVER_SECURE" => ""
);
echo ph_SendEmail($aRecips, $subject, $message, $mailSettings, $aAttach);
die;
