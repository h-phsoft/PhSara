<?php

header("Access-Control-Allow-Origin: *");
?>
<?php

/**
 * (C) 2000-2018 PhSoft.
 */
class cSlider {

  var $Slid_Id = -999;
  var $Slid_Name;
  var $Slid_Rem;
  var $SType_Id = 1;
  var $SCols_Id = 1;
  var $aSlides = array();

  public static function getArray($vWhere = '') {
    $aArray = array();
    $nIdx = 0;
    $sSQL = 'SELECT `slid_id`, `slid_name`, `slid_rem`, `stype_id`, `scols_id`'
            . ' FROM `cpy_slider_mst`';
    if ($vWhere != "") {
      $sSQL .= ' WHERE (' . $vWhere . ')';
    }
    $sSQL .= ' ORDER BY `slid_name`';
    $res = ph_Execute($sSQL);
    if ($res != '') {
      while (!$res->EOF) {
        $aArray[$nIdx] = cSlider::getFields($res);
        $nIdx++;
        $res->MoveNext();
      }
      $res->Close();
    }
    return $aArray;
  }

  public static function getInstanceByName($vName) {
    $cClass = new cSlider();
    $sSQL = 'SELECT `slid_id`, `slid_name`, `slid_rem`, `stype_id`, `scols_id`'
            . ' FROM `cpy_slider_mst`'
            . ' WHERE (UPPER(`slid_name`)=UPPER("' . $vName . '"))';
    $res = ph_Execute($sSQL);
    if ($res != '') {
      if (!$res->EOF) {
        $cClass = cSlider::getFields($res);
        $res->Close();
      }
    }
    return $cClass;
  }

  public static function getInstanceById($nId) {
    $cClass = new cSlider();
    $sSQL = 'SELECT `slid_id`, `slid_name`, `slid_rem`, `stype_id`, `scols_id`'
            . ' FROM `cpy_slider_mst`'
            . ' WHERE (`slid_id`="' . $nId . '")';
    $res = ph_Execute($sSQL);
    if ($res != '') {
      if (!$res->EOF) {
        $cClass = cSlider::getFields($res);
        $res->Close();
      }
    }
    return $cClass;
  }

  public static function getFields($res) {
    $cClass = new cSlider();
    $cClass->Slid_Id = $res->fields("slid_id");
    $cClass->SType_Id = $res->fields("stype_id");
    $cClass->SCols_Id = $res->fields("scols_id");
    $cClass->Slid_Name = $res->fields("slid_name");
    $cClass->Slid_Rem = $res->fields("slid_rem");
    $cClass->aSlides = cSlide::getArray($cClass->Slid_Id);
    return $cClass;
  }

}
