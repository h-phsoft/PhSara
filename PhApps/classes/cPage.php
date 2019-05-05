<?php

header('Access-Control-Allow-Origin: *');
?>
<?php

/**
 * (C) 2000-2018 PhSoft.
 */
class cPage {

  var $Page_Id;
  var $Page_Name;
  var $Status_Id;
  var $Page_Text;
  var $aImages = array();

  public static function getArray($vCond = "") {
    $aArray = array();
    $nIdx = 0;
    $sSQL = 'SELECT `page_id`, `page_name`, `status_id`, `page_text`'
            . ' FROM `cpy_page`'
            . ' WHERE (`status_id`=1)';
    if ($vCond != "") {
      $sSQL .= ' AND (' . $vCond . ')';
    }
    $sSQL .= ' ORDER BY `page_id`';
    $res = ph_Execute($sSQL);
    if ($res != '') {
      while (!$res->EOF) {
        $aArray[$nIdx] = cPage::getFields($res, true);
        $nIdx++;
        $res->MoveNext();
      }
      $res->Close();
    }
    return $aArray;
  }

  public static function getInstance($nId) {
    $cClass = new cPage();
    $sSQL = 'SELECT `page_id`, `page_name`, `status_id`, `page_text`'
            . ' FROM `cpy_page`'
            . ' WHERE (`page_id`="' . $nId . '")';
    $res = ph_Execute($sSQL);
    if ($res != '') {
      if (!$res->EOF) {
        $cClass = cPage::getFields($res, true);
        $res->Close();
      }
    }
    return $cClass;
  }

  public static function getFields($res, $full = true) {
    $cClass = new cPage();
    $cClass->Page_Id = $res->fields("page_id");
    $cClass->Status_Id = $res->fields("status_id");
    $cClass->Page_Name = $res->fields("page_name");
    $cClass->Page_Text = $res->fields("page_text");
    if ($full) {
      $cClass->aImages = cPageImage::getArray($cClass->Page_Id);
    }
    return $cClass;
  }

}
