<?php

header('Access-Control-Allow-Origin: *');
?>
<?php

/**
 * (C) 2000-2019 PhSoft.
 */
class cExhibition {

  var $Exhib_Id = 0;
  var $Exhib_Year = 0;
  var $Exhib_Title1 = "";
  var $Exhib_Title2 = "";
  var $Exhib_Date = "";
  var $Exhib_From = "";
  var $Exhib_To = "";
  var $Exhib_Image = "";
  var $Exhib_Text = "";
  var $Exhib_Intro = "";
  var $Exhib_Info = "";
  var $Exhib_Web = "";
  var $Type_Id = 0;
  var $Kind_Id = 0;
  var $cType;
  var $cKind;
  var $aImages = array();
  var $aArtworks = array();
  var $aVideos = array();

  public static function getArray($vCond = "", $full = true) {
    $aArray = array();
    $nIdx = 0;
    $sSQL = 'SELECT `exhib_id`, `type_id`, `kind_id`, `exhib_year`, `exhib_title1`, `exhib_title2`, `exhib_date`,'
            . ' `exhib_from`, `exhib_to`, `exhib_image`, `exhib_text`, `exhib_intro`, `exhib_info`, `exhib_web`'
            . ' FROM `cpy_exhibition`';
    if ($vCond != "") {
      $sSQL .= ' WHERE (' . $vCond . ')';
    }
    $sSQL .= ' ORDER BY `exhib_year` DESC, `exhib_from` DESC, `exhib_to` DESC, `exhib_id` DESC';
    $res = ph_Execute($sSQL);
    if ($res != '') {
      while (!$res->EOF) {
        $aArray[$nIdx] = cExhibition::getFields($res, $full);
        $nIdx++;
        $res->MoveNext();
      }
      $res->Close();
    }
    return $aArray;
  }

  public static function getInstance($nId, $full = true) {
    $cClass = new cExhibition();
    $sSQL = 'SELECT `exhib_id`, `type_id`, `kind_id`, `exhib_year`, `exhib_title1`, `exhib_title2`, `exhib_date`,'
            . ' `exhib_from`, `exhib_to`, `exhib_image`, `exhib_text`, `exhib_intro`, `exhib_info`, `exhib_web`'
            . ' FROM `cpy_exhibition`';
    if ($nId != "") {
      $sSQL .= ' WHERE (`exhib_id`=' . $nId . ')';
    }
    $res = ph_Execute($sSQL);
    if ($res != '') {
      if (!$res->EOF) {
        $cClass = cExhibition::getFields($res, $full);
        $res->Close();
      }
    }
    return $cClass;
  }

  public static function getFields($res, $full = true) {
    $cClass = new cExhibition();
    $cClass->Exhib_Id = $res->fields("exhib_id");
    $cClass->Type_Id = $res->fields("type_id");
    $cClass->Kind_Id = $res->fields("kind_id");
    $cClass->Exhib_Year = $res->fields("exhib_year");
    $cClass->Exhib_Date = $res->fields("exhib_date");
    $cClass->Exhib_From = $res->fields("exhib_from");
    $cClass->Exhib_To = $res->fields("exhib_to");
    $cClass->Exhib_Image = $res->fields("exhib_image");
    $cClass->Exhib_Title1 = $res->fields("exhib_title1");
    $cClass->Exhib_Title2 = $res->fields("exhib_title2");
    $cClass->Exhib_Text = $res->fields("exhib_text");
    $cClass->Exhib_Intro = $res->fields("exhib_intro");
    $cClass->Exhib_Info = $res->fields("exhib_info");
    $cClass->Exhib_Web = $res->fields("exhib_web");
    $cClass->cType = cExhibitionType::getInstance($cClass->Type_Id);
    $cClass->cKind = cExhibitionKind::getInstance($cClass->Kind_Id);
    if ($full) {
      $cClass->aImages = cExhibitionImages::getArray('`exhib_id`=' . $cClass->Exhib_Id);
      $cClass->aArtworks = cArtWork::getArray('`art_id` IN (SELECT `art_id` FROM `cpy_artwork_exhibtion` WHERE `exhib_id`=' . $cClass->Exhib_Id . ')');
      $cClass->aVideos = cVideo::getArray('`video_id` IN (SELECT `video_id` FROM `cpy_exhibition_video` WHERE `exhib_id`=' . $cClass->Exhib_Id . ')');
    }
    return $cClass;
  }

}
