<?php

header('Access-Control-Allow-Origin: *');
?>
<?php

/**
 * (C) 2000-2019 PhSoft.
 */
class cArtType {

  var $Type_Id = 0;
  var $Type_Order = 0;
  var $Type_Name = "";

  public static function getArray($vCond = "") {
    $aArray = array();
    $nIdx = 0;
    $sSQL = 'SELECT `type_id`, `type_order`, `type_name`'
            . ' FROM `cpy_arttype`';
    if ($vCond != "") {
      $sSQL .= ' WHERE (' . $vCond . ')';
    }
    $sSQL .= ' ORDER BY `type_order`, `type_id`';
    $res = ph_Execute($sSQL);
    if ($res != '') {
      while (!$res->EOF) {
        $aArray[$nIdx] = cArtType::getFields($res);
        $nIdx++;
        $res->MoveNext();
      }
      $res->Close();
    }
    return $aArray;
  }

  public static function getInstance($nId) {
    $cClass = new cArtType();
    $sSQL = 'SELECT `type_id`, `type_order`, `type_name`'
            . ' FROM `cpy_arttype`';
    if ($nId != "") {
      $sSQL .= ' WHERE (`type_id`=' . $nId . ')';
    }
    $sSQL .= ' ORDER BY `type_order`, `type_id`';
    $res = ph_Execute($sSQL);
    if ($res != '') {
      if (!$res->EOF) {
        $cClass = cArtType::getFields($res);
        $res->Close();
      }
    }
    return $cClass;
  }

  public static function getFields($res) {
    $cClass = new cArtType();
    $cClass->Type_Id = $res->fields("type_id");
    $cClass->Type_Order = $res->fields("type_order");
    $cClass->Type_Name = $res->fields("type_name");
    return $cClass;
  }

}
