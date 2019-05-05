<?php

$PH_RELATIVE_PATH = "../";
?>
<?php include_once $PH_RELATIVE_PATH . "phmysql.php" ?>
<?php include_once $PH_RELATIVE_PATH . "phfn.php" ?>
<?php include_once $PH_RELATIVE_PATH . "cpfn.php" ?>
<?php

// Prepare Request variables
ph_PrepareGets();
ph_PreparePosts();

$aArray = array();
$vRet = array('Status' => false, 'Data' => $aArray);

$nPage = ph_Post('page');
$nPages = ph_Post('pages');
$nId = ph_Post('id');
if ($nId > 0 && $nPage > 0) {
  $vPage = '';
  $sSQL = "SELECT `page_num`, `page_text`"
          . " FROM `app_book_page`"
          . " WHERE (`book_id`=" . $nId . " AND `page_num`=" . $nPage . ")";
  $res = ph_Execute($sSQL);
  if ($res != "") {
    while (!$res->EOF) {
      $vPage = '<p class="text-center">' . $res->fields('page_num') . '/' . $nPages . '</p>'
              . $res->fields('page_text')
              . '<p class="text-center">' . $res->fields('page_num') . '/' . $nPages . '</p>';
      $res->MoveNext();
    }
    $res->Close();
  }
  $vRet = array('Status' => true, 'Data' => $vPage);
}

echo json_encode($vRet);
flush();
