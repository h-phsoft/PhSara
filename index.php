<?php
//$PH_BASE_PATH = '/PhSara/';
$PH_BASE_PATH = '/PhSara';
$PH_BASE_IMAGES_PATH = '/PhSara/';
$PH_RELATIVE_PATH = "PhApps/";

$PH_BASE_PATH_ASSETS = '/PhSara/assets/';
$PH_BASE_PATH_CSS = '/PhSara/assets/css/';

$PH_BASE_PATH_IMG = '/PhSara/assets/img/';
$PH_BASE_PATH_IMG_LOGO = '/PhSara/assets/img/logo/';
$PH_BASE_PATH_IMG_ICONS = '/PhSara/assets/img/icons/';
/*
  $PH_BASE_PATH_IMAGES = '/PhSara/assets/img/images/';
  $PH_BASE_PATH_IMAGE_SMALL = '/PhSara/assets/img/small/';
  $PH_BASE_PATH_IMAGE_UPLOADS = '/PhSara/assets/img/uploads/';
 */
$PH_BASE_PATH_IMAGES = 'http://sarashamma.com/images/';
$PH_BASE_PATH_IMAGE_SMALL = 'http://sarashamma.com/small/';
$PH_BASE_PATH_IMAGE_UPLOADS = 'http://sarashamma.com/uploads/';

$PH_SHARE_URL = 'http://sarashamma.com/2/';
$PH_SHARE_PATH_IMAGES = 'http://sarashamma.com/images/';
$PH_SHARE_PATH_IMAGE_SMALL = 'http://sarashamma.com/small/';
$PH_SHARE_PATH_IMAGE_UPLOADS = 'http://sarashamma.com/uploads/';
?>
<?php include_once $PH_RELATIVE_PATH . "phmysql.php" ?>
<?php include_once $PH_RELATIVE_PATH . "phfn.php" ?>
<?php include_once $PH_RELATIVE_PATH . "cpfn.php" ?>
<?php
// Prepare Request variables
ph_PrepareGets();
ph_PreparePosts();

$userAgen = ph_ServerVar('HTTP_USER_AGENT');
if (preg_match('~MSIE|Internet Explorer~i', $userAgen) || (strpos($userAgen, 'Trident/7.0; rv:11.0') !== false)) {
  $artWorkStyle = 'width: 100%; max-height: 100%;';
} else {
  $artWorkStyle = 'max-width: 100%; max-height: 100%;';
}

$nMode = '100';
$nId = -1;
$vURL = '';
$vParams = '';
foreach ($_GET as $key => $value) {
  $vURL = $key;
}
if ($vURL !== '') {
  $nPos = strpos($vURL, '#');
  if ($nPos !== false) {
    $vParams = substr($vURL, $nPos + 1);
    $vURL = substr($vURL, 0, $nPos);
  }
  if ($vURL !== '') {
    $nPos = strpos($vURL, '/');
    if ($nPos !== false) {
      $nMode = substr($vURL, 0, $nPos);
      $vURL = substr($vURL, $nPos + 1);
      if ($vURL !== '') {
        $nId = $vURL;
      }
    } else {
      $nMode = $vURL;
    }
  }
}
if ($nMode == 3101) {
  $nMode = 0;
}

// PhSoft Setting
$ph_Setting_SiteName = ph_Setting('Site-Name');
$ph_Setting_MainMenu = ph_Setting('Main-Menu');
$ph_Setting_SocialsMenu = ph_Setting('Socials-Menu');

if ($ph_Setting_SiteName == "") {
  $ph_Setting_SiteName = "Sara Shamma";
}

$mainMenu = cMenu::getInstance($ph_Setting_MainMenu);
$socialsMenu = cMenu::getInstance($ph_Setting_SocialsMenu);
$cMenu = cMenu::getInstance($nMode, false);
$vHeader = $cMenu->Menu_Name;
$pageName = $cMenu->Menu_Page;
$slider = cSlider::getInstanceById(3);
$vTitle = $vHeader;
if ($nMode == 100 || $nMode == 0) {
  $vTitle = $ph_Setting_SiteName;
} else {
  $vTitle = $vHeader . ' | ' . $ph_Setting_SiteName;
}
?>
<!doctype html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if IE 11]> <html lang="en" class="ie11 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html>
  <!--<![endif]-->
  <head>
    <meta charset="utf-8">
    <title><?php echo $vTitle; ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="google" content="notranslate">
    <meta name="description" content="Sara Shamma is a renowned Syrian artist living and working in London UK, her practice focuses on death and humanity expressed mainly through self-portraits and children painted in a life-like visceral way. Working mainly from life and photographs, the artist uses oils to create a hyper realistic scene, using transparency lines and motion to portray a distant and deep void.">
    <meta name="keywords" content="">
    <meta name="publication_date" content="2015-05-06 10:26:00">
    <meta name="application-name" content="Sara Shamma">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta property="og:site_name" content="Sara Shamma">
    <meta property="og:title" content="Sara Shamma">
    <meta property="og:description" content="Sara Shamma is a renowned Syrian artist living and working in London UK, her practice focuses on death and humanity expressed mainly through self-portraits and children painted in a life-like visceral way. Working mainly from life and photographs, the artist uses oils to create a hyper realistic scene, using transparency lines and motion to portray a distant and deep void.">
    <meta property="og:image" content="">
    <meta property="og:image:width" content="">
    <meta property="og:image:height" content="">
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="http://sarashamma.com/">
    <meta property="twitter:title" content="Sara Shamma">
    <meta property="twitter:description" content="Sara Shamma is a renowned Syrian artist living and working in London UK, her practice focuses on death and humanity expressed mainly through self-portraits and children painted in a life-like visceral way. Working mainly from life and photographs, the artist uses oils to create a hyper realistic scene, using transparency lines and motion to portray a distant and deep void.">
    <meta property="twitter:text:description" content="Sara Shamma is a renowned Syrian artist living and working in London UK, her practice focuses on death and humanity expressed mainly through self-portraits and children painted in a life-like visceral way. Working mainly from life and photographs, the artist uses oils to create a hyper realistic scene, using transparency lines and motion to portray a distant and deep void.">

    <link rel="shortcut icon" href="<?php echo $PH_BASE_PATH_IMG; ?>favicon.ico">

    <link rel="stylesheet" href="<?php echo $PH_BASE_PATH_ASSETS; ?>plugins/bootstrap/css/bootstrap.css">
    <link rel="stylesheet" href="<?php echo $PH_BASE_PATH_ASSETS; ?>plugins/jquery/slick.css">
    <link rel="stylesheet" href="<?php echo $PH_BASE_PATH_ASSETS; ?>plugins/font-awesome/font-awesome.css">
    <link rel="stylesheet" href="<?php echo $PH_BASE_PATH_ASSETS; ?>plugins/jquery/mCustomScrollbar/jquery.mCustomScrollbar.min.css">
    <link rel="stylesheet" href="<?php echo $PH_BASE_PATH_ASSETS; ?>plugins/lightgallery/css/lightgallery.css">
    <link rel="stylesheet" href="<?php echo $PH_BASE_PATH_ASSETS; ?>plugins/slick/slick.css">
    <link rel="stylesheet" href="<?php echo $PH_BASE_PATH_ASSETS; ?>plugins/slick/slick-theme.css">
    <link rel="stylesheet" href="<?php echo $PH_BASE_PATH_CSS; ?>style.css">
  </head>
  <body>
    <?php include "page-header.php" ?>
    <?php
    if ($pageName != '') {
      include $pageName;
    }
    ?>
    <?php include "page-footer.php" ?>
    <script src="<?php echo $PH_BASE_PATH_ASSETS; ?>plugins/jquery/jquery.min.js"></script>
    <script src="<?php echo $PH_BASE_PATH_ASSETS; ?>plugins/popper/popper.min.js"></script>
    <script src="<?php echo $PH_BASE_PATH_ASSETS; ?>plugins/bootstrap/js/bootstrap.js"></script>
    <script src="<?php echo $PH_BASE_PATH_ASSETS; ?>plugins/jquery/jquery.slim.min.js"></script>
    <script src="<?php echo $PH_BASE_PATH_ASSETS; ?>plugins/jquery/mCustomScrollbar/jquery.mCustomScrollbar.concat.min.js"></script>
    <script src="<?php echo $PH_BASE_PATH_ASSETS; ?>plugins/lightgallery/js/lightgallery-all.js"></script>
    <script src="<?php echo $PH_BASE_PATH_ASSETS; ?>plugins/slick/slick.js"></script>
    <script src="<?php echo $PH_BASE_PATH_ASSETS; ?>plugins/jquery/powerzoom/jquery.powerzoom.js"></script>
    <script src="<?php echo $PH_BASE_PATH_ASSETS; ?>js/scripts.js"></script>
  </body>
</html>
