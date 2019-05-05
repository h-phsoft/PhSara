<?php

header("Access-Control-Allow-Origin: *");
?>
<?php

/**
 * (C) 2000-2018 PhSoft.
 */
class cSlide {

  var $TSlid_Id = -999;
  var $Slid_Id = -999;
  var $Slid_Order = 1;
  var $Slid_Image;

  public static function getArray($nPId) {
    $aArray = array();
    $nIdx = 0;
    $sSQL = 'SELECT `tslid_id`, `slid_id`, `slid_order`, `slid_image`'
            . ' FROM `cpy_slider_trn`'
            . ' WHERE (`slid_id`="' . $nPId . '")';
    $sSQL .= ' ORDER BY `slid_order`';
    $res = ph_Execute($sSQL);
    if ($res != '') {
      while (!$res->EOF) {
        $aArray[$nIdx] = cSlide::getFields($res);
        $nIdx++;
        $res->MoveNext();
      }
      $res->Close();
    }
    return $aArray;
  }

  public static function getInstance($nId) {
    $cClass = new cSlide();
    $sSQL = 'SELECT `tslid_id`, `slid_id`, `slid_order`, `slid_image`'
            . ' FROM `cpy_slider_trn`'
            . ' WHERE (`tslid_id`="' . $nId . '")';
    $res = ph_Execute($sSQL);
    if ($res != '') {
      if (!$res->EOF) {
        $cClass = cSlide::getFields($res);
        $res->Close();
      }
    }
    return $cClass;
  }

  public static function getFields($res) {
    $cClass = new cSlide();
    $cClass->TSlid_Id = $res->fields("tslid_id");
    $cClass->Slid_Id = $res->fields("slid_id");
    $cClass->Slid_Order = $res->fields("slid_order");
    $cClass->Slid_Image = $res->fields("slid_image");
    return $cClass;
  }

}
