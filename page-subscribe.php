<?php

$name = ph_Post('sub_name');
$email = ph_Post('sub_email');
$country = ph_Post('sub_country');
$message = ph_Post('sub_message');
$captcha = ph_Post('captcha_code1');

if ($name != '') {
  if ($email != '') {
    if ($country != '') {
      if ($message != '') {
        $securimage = new Securimage();
        if ($securimage->check($captcha) == true) {
          $sSQL = 'INSERT INTO `cpy_subscribe`'
                  . '(`sub_email`, `sub_name`, `sub_country`, `sub_message`)'
                  . '  VALUES '
                  . '( "' . $email . '", "' . $name . '", "' . $country . '", "' . $message . '")';
          ph_Execute($sSQL);
          ph_ResetGets();
          ph_ResetPosts();
        }
      }
    }
  }
}

include "page-main.php";
?>
