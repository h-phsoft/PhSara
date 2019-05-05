<?php

header('Access-Control-Allow-Origin: *');
?>
<?php

/**
 * (C) 2000-2019 PhSoft.
 */
class cSubject {

  var $Subj_Id = 0;
  var $Subj_Order = 0;
  var $Subj_Name = "";

  public static function getArray($vCond = "") {
    $aArray = array();
    $nIdx = 0;
    $sSQL = 'SELECT `subj_id`, `subj_order`, `subj_name`'
            . ' FROM `cpy_subject`';
    if ($vCond != "") {
      $sSQL .= ' WHERE (' . $vCond . ')';
    }
    $sSQL .= ' ORDER BY `subj_order`, `subj_id`';
    $res = ph_Execute($sSQL);
    if ($res != '') {
      while (!$res->EOF) {
        $aArray[$nIdx] = cSubject::getFields($res);
        $nIdx++;
        $res->MoveNext();
      }
      $res->Close();
    }
    return $aArray;
  }

  public static function getInstance($nId) {
    $cClass = new cSubject();
    $sSQL = 'SELECT `subj_id`, `subj_order`, `subj_name`'
            . ' FROM `cpy_subject`';
    if ($nId != "") {
      $sSQL .= ' WHERE (`subj_id`=' . $nId . ')';
    }
    $sSQL .= ' ORDER BY `subj_order`, `subj_id`';
    $res = ph_Execute($sSQL);
    if ($res != '') {
      if (!$res->EOF) {
        $cClass = cSubject::getFields($res);
        $res->Close();
      }
    }
    return $cClass;
  }

  public static function getFields($res) {
    $cClass = new cSubject();
    $cClass->Subj_Id = $res->fields("subj_id");
    $cClass->Subj_Order = $res->fields("subj_order");
    $cClass->Subj_Name = $res->fields("subj_name");
    return $cClass;
  }

}
