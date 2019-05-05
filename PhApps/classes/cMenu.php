<?php

header('Access-Control-Allow-Origin: *');
?>
<?php

/**
 * (C) 2000-2019 PhSoft.
 */
class cMenu {

  var $Menu_Id = 0;
  var $Menu_PId = 0;
  var $Status_Id = 1;
  var $Page_Id = 0;
  var $Menu_Order = 0;
  var $Menu_Name = "";
  var $Menu_Icon = "";
  var $Menu_URL = "#";
  var $Menu_Target = "#";
  var $Menu_Page = "";
  var $aSubs = array();

  public static function getArray($nPId, $full = true) {
    $aArray = array();
    $nIdx = 0;
    $sSQL = 'SELECT `menu_id`, `menu_pid`, `status_id`, `page_id`, `menu_order`, `menu_name`,'
            . ' `menu_icon`, `menu_href`, `menu_target`, `menu_page`'
            . ' FROM `phs_menu`'
            . ' WHERE (`status_id`=1 And `menu_id`!=0)';
    if ($nPId != "") {
      $sSQL .= ' AND (`menu_pid`=' . $nPId . ')';
    }
    $sSQL .= ' ORDER BY `menu_order`';
    $res = ph_Execute($sSQL);
    if ($res != '') {
      while (!$res->EOF) {
        $aArray[$nIdx] = cMenu::getFields($res, $full);
        $nIdx++;
        $res->MoveNext();
      }
      $res->Close();
    }
    return $aArray;
  }

  public static function getInstance($nId, $full = true) {
    $cClass = new cMenu();
    $sSQL = 'SELECT `menu_id`, `menu_pid`, `status_id`, `page_id`, `menu_order`, `menu_name`,'
            . ' `menu_icon`, `menu_href`, `menu_target`, `menu_page`'
            . ' FROM `phs_menu`'
            . ' WHERE (`menu_id`="' . $nId . '")';
    $res = ph_Execute($sSQL);
    if ($res != '') {
      if (!$res->EOF) {
        $cClass = cMenu::getFields($res, $full);
        $res->Close();
      }
    }
    return $cClass;
  }

  public static function getFields($res, $full = true) {
    $cClass = new cMenu();
    $cClass->Menu_Id = $res->fields("menu_id");
    $cClass->Menu_PId = $res->fields("menu_pid");
    $cClass->Status_Id = $res->fields("status_id");
    $cClass->Page_Id = $res->fields("page_id");
    $cClass->Menu_Order = $res->fields("menu_order");
    $cClass->Menu_Name = $res->fields("menu_name");
    $cClass->Menu_Icon = $res->fields("menu_icon");
    $cClass->Menu_URL = $res->fields("menu_href");
    $cClass->Menu_Target = $res->fields("menu_target");
    $cClass->Menu_Page = $res->fields("menu_page");
    if ($full) {
      $cClass->aSubs = cMenu::getArray($cClass->Menu_Id);
    }
    return $cClass;
  }

}
