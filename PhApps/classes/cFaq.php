<?php

header('Access-Control-Allow-Origin: *');
?>
<?php

/**
 * (C) 2000-2019 PhSoft.
 */
class cFaq {

  var $FAQ_Id;
  var $FCat_Id;
  var $Lang_Id;
  var $FAQ_Order;
  var $Status_Id;
  var $FAQ_Title;
  var $FAQ_Text;

  public static function getArray($vCond = "") {
    $aArray = array();
    $nIdx = 0;
    $sSQL = 'SELECT `faq_id`, `fcat_id`, `lang_id`, `faq_order`, `status_id`, `faq_title`, `faq_text`'
            . ' FROM `cpy_faq`'
            . ' WHERE (`status_id`=1)';
    if ($vCond != "") {
      $sSQL .= ' AND (' . $vCond . ')';
    }
    $sSQL .= ' ORDER BY `faq_order`';
    $res = ph_Execute($sSQL);
    if ($res != '') {
      while (!$res->EOF) {
        $aArray[$nIdx] = cFaq::getFields($res, true);
        $nIdx++;
        $res->MoveNext();
      }
      $res->Close();
    }
    return $aArray;
  }

  public static function getInstance($nId) {
    $cClass = new cFaq();
    $sSQL = 'SELECT `faq_id`, `fcat_id`, `lang_id`, `faq_order`, `status_id`, `faq_title`, `faq_text`'
            . ' FROM `cpy_faq`'
            . ' WHERE (`faq_id`="' . $nId . '")';
    $res = ph_Execute($sSQL);
    if ($res != '') {
      if (!$res->EOF) {
        $cClass = cFaq::getFields($res, true);
        $res->Close();
      }
    }
    return $cClass;
  }

  public static function getFields($res, $full = true) {
    $cClass = new cFaq();
    $cClass->FAQ_Id = $res->fields("faq_id");
    $cClass->FCat_Id = $res->fields("fcat_id");
    $cClass->Lang_Id = $res->fields("lang_id");
    $cClass->Status_Id = $res->fields("status_id");
    $cClass->FAQ_Order = $res->fields("faq_order");
    $cClass->FAQ_Title = $res->fields("faq_title");
    $cClass->FAQ_Text = $res->fields("faq_text");
    return $cClass;
  }

}
