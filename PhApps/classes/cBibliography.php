<?php

header('Access-Control-Allow-Origin: *');
?>
<?php

/**
 * (C) 2000-2019 PhSoft.
 */
class cBibliography {

  var $Bibl_Id = 0;
  var $Bibl_Order = 0;
  var $Bibl_Title1 = "";
  var $Bibl_Title2 = "";
  var $Bibl_Image = "";
  var $Bibl_Text = "";

  public static function getArray($vCond = "") {
    $aArray = array();
    $nIdx = 0;
    $sSQL = 'SELECT `bibl_id`, `bibl_order`, `bibl_title1`, `bibl_title2`, `bibl_image`, `bibl_text`'
            . ' FROM `cpy_bibliography`';
    if ($vCond != "") {
      $sSQL .= ' WHERE (' . $vCond . ')';
    }
    $sSQL .= ' ORDER BY `bibl_order`, `bibl_id`';
    $res = ph_Execute($sSQL);
    if ($res != '') {
      while (!$res->EOF) {
        $aArray[$nIdx] = cBibliography::getFields($res);
        $nIdx++;
        $res->MoveNext();
      }
      $res->Close();
    }
    return $aArray;
  }

  public static function getInstance($nId) {
    $cClass = new cBibliography();
    $sSQL = 'SELECT `bibl_id`, `bibl_order`, `bibl_title1`, `bibl_title2`, `bibl_image`, `bibl_text`'
            . ' FROM `cpy_bibliography`';
    if ($nId != "") {
      $sSQL .= ' WHERE (`bibl_id`=' . $nId . ')';
    }
    $res = ph_Execute($sSQL);
    if ($res != '') {
      if (!$res->EOF) {
        $cClass = cBibliography::getFields($res);
        $res->Close();
      }
    }
    return $cClass;
  }

  public static function getFields($res) {
    $cClass = new cBibliography();
    $cClass->Bibl_Id = $res->fields("bibl_id");
    $cClass->Bibl_Order = $res->fields("bibl_order");
    $cClass->Bibl_Title1 = $res->fields("bibl_title1");
    $cClass->Bibl_Title2 = $res->fields("bibl_title2");
    $cClass->Bibl_Image = $res->fields("bibl_image");
    $cClass->Bibl_Text = $res->fields("bibl_text");
    return $cClass;
  }

}
