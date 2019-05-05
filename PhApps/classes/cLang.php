<?php

header('Access-Control-Allow-Origin: *');
?>
<?php

/**
 * (C) 2000-2019 PhSoft.
 */
class cLang {

  var $Lang_Id;
  var $Status_Id = 1;
  var $Lang_Name = 'English';
  var $Lang_DName = 'English';
  var $Lang_Dir = 'LTR';
  var $Lang_Code = 'en';

  public static function getArray($vCond = "") {
    $aArray = array();
    $nIdx = 0;
    $sSQL = 'SELECT `lang_id`, `status_id`, `lang_name`, `lang_dname`, `lang_dir`, `lang_code`'
            . ' FROM `phs_language`'
            . ' WHERE (`status_id`=1)';
    if ($vCond != "") {
      $sSQL .= ' AND (' . $vCond . ')';
    }
    $sSQL .= ' ORDER BY `lang_name`';
    $res = ph_Execute($sSQL);
    if ($res != '') {
      while (!$res->EOF) {
        $aArray[$nIdx] = cLang::getFields($res);
        $nIdx++;
        $res->MoveNext();
      }
      $res->Close();
    }
    return $aArray;
  }

  public static function getInstance($nId) {
    $cClass = new cLang();
    $sSQL = 'SELECT `lang_id`, `status_id`, `lang_name`, `lang_dname`, `lang_dir`, `lang_code`'
            . ' FROM `phs_language`'
            . ' WHERE (`lang_id`="' . $nId . '")';
    $res = ph_Execute($sSQL);
    if ($res != '') {
      if (!$res->EOF) {
        $cClass = cLang::getFields($res);
        $res->Close();
      }
    }
    return $cClass;
  }

  public static function getFields($res) {
    $cClass = new cLang();
    $cClass->Lang_Id = $res->fields("lang_id");
    $cClass->Status_Id = $res->fields("status_id");
    $cClass->Lang_Name = $res->fields("lang_name");
    $cClass->Lang_DName = $res->fields("lang_dname");
    $cClass->Lang_Dir = $res->fields("lang_dir");
    $cClass->Lang_Code = $res->fields("lang_code");
    return $cClass;
  }

  public static function renderLangs($cLang) {
    $vLangs = chr(13);
    $aLangs = cLang::getArray();
    if (count($aLangs) > 3) {
      $vLangs .= '<li class="langs-block">' . chr(13);
      $vLangs .= '  <a class="current">' . $cLang->Lang_Name . '</a>' . chr(13);
      $vLangs .= '  <div class="langs-block-others-wrapper">' . chr(13);
      $vLangs .= '    <div class="langs-block-others">' . chr(13);
      foreach ($aLangs as $lang) {
        if ($lang->Lang_Id != $cLang->Lang_Id) {
          $vLangs .= '      <a href="?l=' . $lang->Lang_Id . '">' . $lang->Lang_Name . '</a>' . chr(13);
        }
      }
      $vLangs .= '    </div>' . chr(13);
      $vLangs .= '  </div>' . chr(13);
      $vLangs .= '</li>' . chr(13);
    } else if (count($aLangs) > 1) {
      foreach ($aLangs as $lang) {
        if ($lang->Lang_Id != $cLang->Lang_Id) {
          $vLangs .= '<li class="langs-block">' . chr(13);
          $vLangs .= '  <a href="?l=' . $lang->Lang_Id . '">' . $lang->Lang_Name . '</a>' . chr(13);
          $vLangs .= '</li>' . chr(13);
        }
      }
    }
    return $vLangs;
  }

}
