<?php

header('Access-Control-Allow-Origin: *');
?>
<?php

/**
 * (C) 2000-2019 PhSoft.
 */
class cFaqCategory {

  var $FCat_Id;
  var $FCat_Order;
  var $Status_Id;
  var $FCat_Name;
  var $aFAQs = array();

  public static function getArray($vCond = "") {
    $aArray = array();
    $nIdx = 0;
    $sSQL = 'SELECT `fcat_id`, `fcat_order`, `status_id`, `fcat_name`'
            . ' FROM `cpy_faq_category`'
            . ' WHERE (`status_id`=1)';
    if ($vCond != "") {
      $sSQL .= ' WHERE (' . $vCond . ')';
    }
    $sSQL .= ' ORDER BY `fcat_order`';
    $res = ph_Execute($sSQL);
    if ($res != '') {
      while (!$res->EOF) {
        $aArray[$nIdx] = cFaqCategory::getFields($res, true);
        $nIdx++;
        $res->MoveNext();
      }
      $res->Close();
    }
    return $aArray;
  }

  public static function getInstance($nId) {
    $cClass = new cFaqCategory();
    $sSQL = 'SELECT `fcat_id`, `fcat_order`, `status_id`, `fcat_name`'
            . ' FROM `cpy_faq_category`'
            . ' WHERE (`fcat_id`="' . $nId . '")';
    $res = ph_Execute($sSQL);
    if ($res != '') {
      if (!$res->EOF) {
        $cClass = cFaqCategory::getFields($res, true);
        $res->Close();
      }
    }
    return $cClass;
  }

  public static function getFields($res, $full = true) {
    $cClass = new cFaqCategory();
    $cClass->FCat_Id = $res->fields("fcat_id");
    $cClass->Status_Id = $res->fields("status_id");
    $cClass->FCat_Order = $res->fields("fcat_order");
    $cClass->FCat_Name = $res->fields("fcat_name");
    if ($full) {
      $cClass->aFAQs = cFaq::getArray('(fcat_id=' . $cClass->FCat_Id . ')');
    }
    return $cClass;
  }

}
