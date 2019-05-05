<?php

header('Access-Control-Allow-Origin: *');
?>
<?php

/**
 * (C) 2000-2019 PhSoft.
 */
class cExhibitionKind {

  var $Kind_Id = 0;
  var $Kind_Order = 0;
  var $Kind_Name = "";

  public static function getArray($vCond = "") {
    $aArray = array();
    $nIdx = 0;
    $sSQL = 'SELECT `kind_id`, `kind_order`, `kind_name`'
            . ' FROM `cpy_exhibkind`';
    if ($vCond != "") {
      $sSQL .= ' WHERE (' . $vCond . ')';
    }
    $sSQL .= ' ORDER BY `kind_order`, `kind_id`';
    $res = ph_Execute($sSQL);
    if ($res != '') {
      while (!$res->EOF) {
        $aArray[$nIdx] = cExhibitionKind::getFields($res);
        $nIdx++;
        $res->MoveNext();
      }
      $res->Close();
    }
    return $aArray;
  }

  public static function getInstance($nId) {
    $cClass = new cExhibitionKind();
    $sSQL = 'SELECT `kind_id`, `kind_order`, `kind_name`'
            . ' FROM `cpy_exhibkind`';
    if ($nId != "") {
      $sSQL .= ' WHERE (`kind_id`=' . $nId . ')';
    }
    $sSQL .= ' ORDER BY `kind_order`, `kind_id`';
    $res = ph_Execute($sSQL);
    if ($res != '') {
      if (!$res->EOF) {
        $cClass = cExhibitionKind::getFields($res);
        $res->Close();
      }
    }
    return $cClass;
  }

  public static function getFields($res) {
    $cClass = new cExhibitionKind();
    $cClass->Kind_Id = $res->fields("kind_id");
    $cClass->Kind_Order = $res->fields("kind_order");
    $cClass->Kind_Name = $res->fields("kind_name");
    return $cClass;
  }

}
