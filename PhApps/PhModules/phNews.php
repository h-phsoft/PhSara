<?php include_once "../phmysql.php" ?>
<?php include_once "../phfn.php" ?>
<?php include_once "../cpfn.php" ?>
<?php

// Prepare Request variables
ph_PrepareGets();
ph_PreparePosts();

$aArray = array();
$vRet = array('Status' => false, 'Data' => $aArray);

$nSYear = ph_Post('nSYear');
$nEYear = ph_Post('nEYear');
$aNews = cNews::getArray("YEAR(`news_date`) BETWEEN " . $nSYear . " AND " . $nEYear);
if (count($aNews) > 0) {
  $vRet = array('Status' => true, 'Data' => $aNews);
}

echo json_encode($vRet);
flush();
