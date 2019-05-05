<?php

header('Access-Control-Allow-Origin: *');
?>
<?php

/**
 * (C) 2000-2019 PhSoft.
 */
class cCountry {

  var $Cntry_Id;
  var $Status_Id;
  var $Cntry_Code;
  var $Cntry_Name;

  public static function getArray($vCond = "") {
    $aArray = array();
    $nIdx = 0;
    $sSQL = 'SELECT `cntry_id`, `status_id`, `cntry_code`, `cntry_name`'
            . ' FROM `phs_country`'
            . ' WHERE (`status_id`=1)';
    if ($vCond != "") {
      $sSQL .= ' AND (' . $vCond . ')';
    }
    $sSQL .= ' ORDER BY `cntry_id`';
    $res = ph_Execute($sSQL);
    if ($res != '') {
      while (!$res->EOF) {
        $aArray[$nIdx] = cCountry::getFields($res);
        $nIdx++;
        $res->MoveNext();
      }
      $res->Close();
    }
    return $aArray;
  }

  public static function getInstance($nId) {
    $cClass = new cCountry();
    $sSQL = 'SELECT `cntry_id`, `status_id`, `cntry_code`, `cntry_name`'
            . ' FROM `phs_country`'
            . ' WHERE `cntry_id`=' . $nId;
    $res = ph_Execute($sSQL);
    if ($res != '') {
      if (!$res->EOF) {
        $cClass = cCountry::getFields($res);
        $res->Close();
      }
    }
    return $cClass;
  }

  public static function getFields($res) {
    $cClass = new cCountry();
    $cClass->Cntry_Id = $res->fields("cntry_id");
    $cClass->Status_Id = $res->fields("status_id");
    $cClass->Cntry_Code = $res->fields("cntry_code");
    $cClass->Cntry_Name = $res->fields("cntry_name");
    return $cClass;
  }

}
