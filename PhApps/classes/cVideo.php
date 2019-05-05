<?php

header('Access-Control-Allow-Origin: *');
?>
<?php

/**
 * (C) 2000-2019 PhSoft.
 */
class cVideo {

  var $Video_Id = 0;
  var $Video_Date = 0;
  var $Video_Title1 = "";
  var $Video_Title2 = "";
  var $Video_URL = "";
  var $Video_Text = "";

  public static function getArray($vCond = "") {
    $aArray = array();
    $nIdx = 0;
    $sSQL = 'SELECT `video_id`, `video_date`, `video_title1`, `video_title2`, `video_url`, `video_text`'
            . ' FROM `cpy_video`';
    if ($vCond != "") {
      $sSQL .= ' WHERE (' . $vCond . ')';
    }
    $sSQL .= ' ORDER BY `video_date` DESC, `video_id` DESC';
    $res = ph_Execute($sSQL);
    if ($res != '') {
      while (!$res->EOF) {
        $aArray[$nIdx] = cVideo::getFields($res);
        $nIdx++;
        $res->MoveNext();
      }
      $res->Close();
    }
    return $aArray;
  }

  public static function getInstance($nId) {
    $cClass = new cVideo();
    $sSQL = 'SELECT `video_id`, `video_date`, `video_title1`, `video_title2`, `video_url`, `video_text`'
            . ' FROM `cpy_video`';
    if ($nId != "") {
      $sSQL .= ' WHERE (`video_id`=' . $nId . ')';
    }
    $res = ph_Execute($sSQL);
    if ($res != '') {
      if (!$res->EOF) {
        $cClass = cVideo::getFields($res);
        $res->Close();
      }
    }
    return $cClass;
  }

  public static function getFields($res) {
    $cClass = new cVideo();
    $cClass->Video_Id = $res->fields("video_id");
    $cClass->Video_Date = $res->fields("video_date");
    $cClass->Video_Title1 = $res->fields("video_title1");
    $cClass->Video_Title2 = $res->fields("video_title2");
    $cClass->Video_URL = $res->fields("video_url");
    $cClass->Video_Text = $res->fields("video_text");
    return $cClass;
  }

}
