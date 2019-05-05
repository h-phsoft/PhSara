<?php

header('Access-Control-Allow-Origin: *');
?>
<?php

/**
 * (C) 2000-2019 PhSoft.
 */
class cPublication {

  var $Pub_Id = 0;
  var $Pub_Order = 0;
  var $Pub_Title1 = "";
  var $Pub_Title2 = "";
  var $Pub_Image = "";
  var $Pub_Text = "";
  var $Pub_Publisher = "";
  var $Pub_Editor = "";
  var $Pub_Dimensions = "";
  var $Bibl_Id = 0;
  var $cBibliography;

  public static function getArray($vCond = "") {
    $aArray = array();
    $nIdx = 0;
    $sSQL = 'SELECT `pub_id`, `pub_order`, `pub_title1`, `pub_title2`, `pub_image`, `pub_text`,'
            . ' `pub_publisher`, `pub_editor`, `pub_dimensions`, `bibl_id`'
            . ' FROM `cpy_publication`';
    if ($vCond != "") {
      $sSQL .= ' WHERE (' . $vCond . ')';
    }
    $sSQL .= ' ORDER BY `pub_order`, `pub_id` DESC';
    $res = ph_Execute($sSQL);
    if ($res != '') {
      while (!$res->EOF) {
        $aArray[$nIdx] = cPublication::getFields($res);
        $nIdx++;
        $res->MoveNext();
      }
      $res->Close();
    }
    return $aArray;
  }

  public static function getInstance($nId) {
    $cClass = new cPublication();
    $sSQL = 'SELECT `pub_id`, `pub_order`, `pub_title1`, `pub_title2`, `pub_image`, `pub_text`,'
            . ' `pub_publisher`, `pub_editor`, `pub_dimensions`, `bibl_id`'
            . ' FROM `cpy_publication`';
    if ($nId != "") {
      $sSQL .= ' WHERE (`pub_id`=' . $nId . ')';
    }
    $res = ph_Execute($sSQL);
    if ($res != '') {
      if (!$res->EOF) {
        $cClass = cPublication::getFields($res);
        $res->Close();
      }
    }
    return $cClass;
  }

  public static function getFields($res) {
    $cClass = new cPublication();
    $cClass->Pub_Id = $res->fields("pub_id");
    $cClass->Pub_Order = $res->fields("pub_order");
    $cClass->Pub_Title1 = $res->fields("pub_title1");
    $cClass->Pub_Title2 = $res->fields("pub_title2");
    $cClass->Pub_Image = $res->fields("pub_image");
    $cClass->Pub_Text = $res->fields("pub_text");
    $cClass->Pub_Publisher = $res->fields("pub_publisher");
    $cClass->Pub_Editor = $res->fields("pub_editor");
    $cClass->Pub_Dimensions = $res->fields("pub_dimensions");
    $cClass->Bibl_Id = $res->fields("bibl_id");
    $cClass->cBibliography = cBibliography::getInstance($cClass->Bibl_Id);
    return $cClass;
  }

}
