<?php

header('Access-Control-Allow-Origin: *');
?>
<?php

/**
 * (C) 2000-2019 PhSoft.
 */
class cExhibitionImages {

  var $IExhib_Id = 0;
  var $Exhib_Id = 0;
  var $Exhib_Order = 0;
  var $Exhib_Image = "";

  public static function getArray($vCond = "") {
    $aArray = array();
    $nIdx = 0;
    $sSQL = 'SELECT `iexhib_id`, `exhib_id`, `exhib_order`, `exhib_image`'
            . ' FROM `cpy_exhibition_images`';
    if ($vCond != "") {
      $sSQL .= ' WHERE (' . $vCond . ')';
    }
    $sSQL .= ' ORDER BY `exhib_order`, `iexhib_id`';
    $res = ph_Execute($sSQL);
    if ($res != '') {
      while (!$res->EOF) {
        $aArray[$nIdx] = cExhibitionImages::getFields($res);
        $nIdx++;
        $res->MoveNext();
      }
      $res->Close();
    }
    return $aArray;
  }

  public static function getInstance($nId) {
    $cClass = new cExhibitionImages();
    $sSQL = 'SELECT `iexhib_id`, `exhib_id`, `exhib_order`, `exhib_image`'
            . ' FROM `cpy_exhibition_images`';
    if ($nId != "") {
      $sSQL .= ' WHERE (`exhib_id`=' . $nId . ')';
    }
    $sSQL .= ' ORDER BY `iexhib_id`';
    $res = ph_Execute($sSQL);
    if ($res != '') {
      if (!$res->EOF) {
        $cClass = cExhibitionImages::getFields($res);
        $res->Close();
      }
    }
    return $cClass;
  }

  public static function getFields($res) {
    $cClass = new cExhibitionImages();
    $cClass->IExhib_Id = $res->fields("iexhib_id");
    $cClass->Exhib_Id = $res->fields("exhib_id");
    $cClass->Exhib_Order = $res->fields("exhib_order");
    $cClass->Exhib_Image = $res->fields("exhib_image");
    return $cClass;
  }

}
