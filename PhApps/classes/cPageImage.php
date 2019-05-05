<?php

header('Access-Control-Allow-Origin: *');
?>
<?php

/**
 * (C) 2000-2018 PhSoft.
 */
class cPageImage {

  var $IPage_Id;
  var $Page_Id;
  var $Page_Order;
  var $Page_Image;

  public static function getArray($nPageId = "") {
    $aArray = array();
    $nIdx = 0;
    $sSQL = 'SELECT `ipage_id`, `page_id`, `page_order`, `page_image`'
            . ' FROM `cpy_page_images`';
    if ($nPageId != "") {
      $sSQL .= ' WHERE (`page_id`="' . $nPageId . '")';
    }
    $sSQL .= ' ORDER BY `page_order`';
    $res = ph_Execute($sSQL);
    if ($res != '') {
      while (!$res->EOF) {
        $aArray[$nIdx] = cPageImage::getFields($res);
        $nIdx++;
        $res->MoveNext();
      }
      $res->Close();
    }
    return $aArray;
  }

  public static function getInstance($nId) {
    $cClass = new cPage();
    $sSQL = 'SELECT `ipage_id`, `page_id`, `page_order`, `page_image`'
            . ' FROM `cpy_page_images`'
            . ' WHERE (`ipage_id`="' . $nId . '")';
    $res = ph_Execute($sSQL);
    if ($res != '') {
      if (!$res->EOF) {
        $cClass = cPageImage::getFields($res);
        $res->Close();
      }
    }
    return $cClass;
  }

  public static function getFields($res) {
    $cClass = new cPageImage();
    $cClass->IPage_Id = $res->fields("ipage_id");
    $cClass->Page_Id = $res->fields("page_id");
    $cClass->Page_Order = $res->fields("page_order");
    $cClass->Page_Image = $res->fields("page_image");
    return $cClass;
  }

}
