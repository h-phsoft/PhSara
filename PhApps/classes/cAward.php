<?php

header('Access-Control-Allow-Origin: *');
?>
<?php

/**
 * (C) 2000-2019 PhSoft.
 */
class cAward {

  var $Award_Id = 0;
  var $Award_Order = 0;
  var $Award_Title1 = "";
  var $Award_Title2 = "";
  var $Award_Image = "";
  var $Award_Text = "";

  public static function getArray($vCond = "") {
    $aArray = array();
    $nIdx = 0;
    $sSQL = 'SELECT `award_id`, `award_order`, `award_title1`, `award_title2`, `award_image`, `award_text`'
            . ' FROM `cpy_award`';
    if ($vCond != "") {
      $sSQL .= ' WHERE (' . $vCond . ')';
    }
    $sSQL .= ' ORDER BY `award_order`, `award_id`';
    $res = ph_Execute($sSQL);
    if ($res != '') {
      while (!$res->EOF) {
        $aArray[$nIdx] = cAward::getFields($res);
        $nIdx++;
        $res->MoveNext();
      }
      $res->Close();
    }
    return $aArray;
  }

  public static function getInstance($nId) {
    $cClass = new cAward();
    $sSQL = 'SELECT `award_id`, `award_order`, `award_title1`, `award_title2`, `award_image`, `award_text`'
            . ' FROM `cpy_award`';
    if ($nId != "") {
      $sSQL .= ' WHERE (`award_id`=' . $nId . ')';
    }
    $res = ph_Execute($sSQL);
    if ($res != '') {
      if (!$res->EOF) {
        $cClass = cAward::getFields($res);
        $res->Close();
      }
    }
    return $cClass;
  }

  public static function getFields($res) {
    $cClass = new cAward();
    $cClass->Award_Id = $res->fields("award_id");
    $cClass->Award_Order = $res->fields("award_order");
    $cClass->Award_Title1 = $res->fields("award_title1");
    $cClass->Award_Title2 = $res->fields("award_title2");
    $cClass->Award_Image = $res->fields("award_image");
    $cClass->Award_Text = $res->fields("award_size");
    return $cClass;
  }

}
