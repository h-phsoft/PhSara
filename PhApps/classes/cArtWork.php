<?php

header('Access-Control-Allow-Origin: *');
?>
<?php

/**
 * (C) 2000-2019 PhSoft.
 */
class cArtWork {

  var $Art_Id = 0;
  var $Art_Year = 0;
  var $Type_Id = 0;
  var $Type_Order = 0;
  var $Type_Name = "";
  var $Art_Title1 = "";
  var $Art_Title2 = "";
  var $Art_Image = "";
  var $Art_Size = "";
  var $aSubjects = array();
  var $aExhibitions = array();

  public static function getArray($vCond = "", $full = true) {
    $aArray = array();
    $nIdx = 0;
    $sSQL = 'SELECT `art_id`, `type_id`, `type_order`, `type_name`, `art_year`, `art_title1`, `art_title2`, `art_size`, `art_image`'
            . ' FROM `cpy_vartwork`';
    if ($vCond != "") {
      $sSQL .= ' WHERE (' . $vCond . ')';
    }
    $sSQL .= ' ORDER BY `art_year` DESC, `art_id` DESC';
    $res = ph_Execute($sSQL);
    if ($res != '') {
      while (!$res->EOF) {
        $aArray[$nIdx] = cArtWork::getFields($res, $full);
        $nIdx++;
        $res->MoveNext();
      }
      $res->Close();
    }
    return $aArray;
  }

  public static function getInstance($nId, $full = true) {
    $cClass = new cArtWork();
    $sSQL = 'SELECT `art_id`, `type_id`, `type_order`, `type_name`, `art_year`, `art_title1`, `art_title2`, `art_size`, `art_image`'
            . ' FROM `cpy_vartwork`';
    if ($nId != "") {
      $sSQL .= ' WHERE (`art_id`=' . $nId . ')';
    }
    $res = ph_Execute($sSQL);
    if ($res != '') {
      if (!$res->EOF) {
        $cClass = cArtWork::getFields($res, $full);
        $res->Close();
      }
    }
    return $cClass;
  }

  public static function getYears($vCond = "") {
    $aArray = array();
    $nIdx = 0;
    $sSQL = 'SELECT DISTINCT `art_year`'
            . ' FROM `cpy_artwork`';
    if ($vCond != "") {
      $sSQL .= ' WHERE (' . $vCond . ')';
    }
    $sSQL .= ' ORDER BY `art_year` DESC';
    $res = ph_Execute($sSQL);
    if ($res != '') {
      while (!$res->EOF) {
        $aArray[$nIdx] = $res->fields("art_year");
        $nIdx++;
        $res->MoveNext();
      }
      $res->Close();
    }
    return $aArray;
  }

  public static function getFields($res, $full = true) {
    $cClass = new cArtWork();
    $cClass->Art_Id = $res->fields("art_id");
    $cClass->Art_Year = $res->fields("art_year");
    $cClass->Type_Id = $res->fields("type_id");
    $cClass->Type_Order = $res->fields("type_order");
    $cClass->Type_Name = $res->fields("type_name");
    $cClass->Art_Title1 = $res->fields("art_title1");
    $cClass->Art_Title2 = $res->fields("art_title2");
    $cClass->Art_Image = $res->fields("art_image");
    $cClass->Art_Size = $res->fields("art_size");
    if ($full) {
      $cClass->aSubjects = cSubject::getArray('`subj_id` IN (SELECT `subj_id` FROM `cpy_sunject` WHERE `art_id`=' . $cClass->Art_Id . ')');
      $cClass->aExhibitions = cExhibition::getArray('`exhib_id` IN (SELECT `subj_id` FROM `cpy_sunject` WHERE `art_id`=' . $cClass->Art_Id . ')');
    }
    return $cClass;
  }

}
