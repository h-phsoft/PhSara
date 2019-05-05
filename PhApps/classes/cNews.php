<?php

header('Access-Control-Allow-Origin: *');
?>
<?php

/**
 * (C) 2000-2019 PhSoft.
 */
class cNews {

  var $News_Id;
  var $News_Date;
  var $Status_Id;
  var $News_Title;
  var $News_Image;
  var $News_Text;

  public static function getArray($vCond = "") {
    $aArray = array();
    $nIdx = 0;
    $sSQL = 'SELECT `news_id`, `news_date`, `status_id`, `news_title`, `news_image`, `news_text`'
            . ' FROM `cpy_news`'
            . ' WHERE (`status_id`=1)';
    if ($vCond != "") {
      $sSQL .= ' AND (' . $vCond . ')';
    }
    $sSQL .= ' ORDER BY `news_date` DESC';
    $res = ph_Execute($sSQL);
    if ($res != '') {
      while (!$res->EOF) {
        $aArray[$nIdx] = cNews::getFields($res);
        $nIdx++;
        $res->MoveNext();
      }
      $res->Close();
    }
    return $aArray;
  }

  public static function getInstance($nId) {
    $cClass = new cNews();
    $sSQL = 'SELECT `news_id`, `news_date`, `status_id`, `news_title`, `news_image`, `news_text`'
            . ' FROM `cpy_news`'
            . ' WHERE (`news_id`="' . $nId . '")';
    $res = ph_Execute($sSQL);
    if ($res != '') {
      if (!$res->EOF) {
        $cClass = cNews::getFields($res);
        $res->Close();
      }
    }
    return $cClass;
  }

  public static function getImages($nId) {
    $aArray = array();
    $nIdx = 0;
    $sSQL = 'SELECT `nimg_id`, `news_id`, `nimg_order`, `nimg_photo`'
            . ' FROM `cpy_news_images`'
            . ' WHERE (`news_id`=' . $nId . ')'
            . ' ORDER BY `nimg_order`';
    $res = ph_Execute($sSQL);
    if ($res != '') {
      while (!$res->EOF) {
        $aArray[$nIdx] = $res->fields("nimg_photo");
        $nIdx++;
        $res->MoveNext();
      }
      $res->Close();
    }
    return $aArray;
  }

  public static function getFields($res) {
    $cClass = new cNews();
    $cClass->News_Id = $res->fields("news_id");
    $cClass->Status_Id = $res->fields("status_id");
    $cClass->News_Date = $res->fields("news_date");
    $cClass->News_Title = $res->fields("news_title");
    $cClass->News_Image = $res->fields("news_image");
    $cClass->News_Text = $res->fields("news_text");
    return $cClass;
  }

}
