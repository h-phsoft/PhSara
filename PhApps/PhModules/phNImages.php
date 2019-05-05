<?php include_once "../phmysql.php" ?>
<?php include_once "../phfn.php" ?>
<?php include_once "../cpfn.php" ?>
<?php

// Prepare Request variables
ph_PrepareGets();
ph_PreparePosts();

$aArray = array();
$vRet = array('Status' => false, 'Data' => $aArray);

$nId = ph_Post('nId');
$aNImages = cNews::getImages($nId);
if (count($aNImages) > 0) {
  $aArray = array();
  foreach ($aNImages as $vImage) {
    $aArray[] = array('src' => 'assets/img/newsImages/' . $vImage);
  }
  $vRet = array('Status' => true, 'Data' => $aArray);
}

echo json_encode($vRet);
flush();
