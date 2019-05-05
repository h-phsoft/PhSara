<?php
$aArtTypes = cArtType::getArray();
$nSubject = 0;
$nYear = 0;
if ($nId != -1) {
  $nPos = strpos($nId, '/');
  if ($nPos !== false) {
    $vParams = substr($nId, $nPos + 1);
    $nId = substr($nId, 0, $nPos);
  }
} else {
  $nId = $aArtTypes[0]->Type_Id;
}
if ($vParams != '') {
  $nPos = strpos($vParams, '/');
  if ($nPos !== false) {
    $nYear = substr($vParams, 0, $nPos);
    $nSubject = substr($vParams, $nPos + 1);
  }
}
$vCond = "`type_id`=" . $nId;
$vYearCond = "`type_id`=" . $nId;
if ($nYear != 0) {
  $vYearCond = $vCond . ' AND `art_year`!=' . $nYear;
  $vCond .= ' AND `art_year`=' . $nYear;
}
$vSubjCond = '`subj_id` IN (SELECT DISTINCT `subj_id` FROM `cpy_vartwork_subjects` WHERE ' . $vCond . ')';
if ($nSubject != 0) {
  $vSubjCond = '`subj_id` IN (SELECT DISTINCT `subj_id` FROM `cpy_vartwork_subjects` WHERE ' . $vCond . ' AND `subj_id`!=' . $nSubject . ')';
  $vCond .= ' AND `art_id` IN (SELECT DISTINCT `art_id` FROM `cpy_artwork_subject` WHERE `subj_id`=' . $nSubject . ')';
}
$aArtWorks = cArtWork::getArray($vCond, false);

$aYears = cArtWork::getYears($vYearCond);
$aSubjects = cSubject::getArray($vSubjCond);
?>
<div class="container">
  <div class="row mt-5 mb-2 text-center">
    <div class="col-12">
      <h4><?php echo $cMenu->Menu_Name; ?></h4>
    </div>
  </div>
  <div class="row mb-4">
    <div class="col-6" style="list-style: none; white-space: nowrap; padding-right: 25px;">
      <?php
      $nIdx = 0;
      foreach ($aArtTypes as $type) {
        $vColor = 'rgba(0, 0, 0, 0.5);';
        if ($nId === $type->Type_Id) {
          $vColor = 'rgba(0, 0, 0, 1);';
        }
        $nIdx = 2 - $nIdx;
        ?>
        <li class="nav-item text-right">
          <a href="<?php echo $PH_BASE_PATH . '?' . $nMode . '/' . $type->Type_Id; ?>" style="color: <?php echo $vColor; ?>"><?php echo $type->Type_Name; ?></a>
        </li>
        <?php
      }
      ?>
    </div>
    <div class="col-6">
      <div class="dropdown" style=" padding-left: 25px;">
        <a href="#" role="link" id="YearsMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="color: rgba(0, 0, 0, 0.5);">
          Year <img width="15" src="<?php echo $PH_BASE_PATH_IMG_ICONS ?>/dropdown_icon.svg">
        </a>
        <div class="dropdown-menu" aria-labelledby="YearsMenuLink" style="z-index: 99999;">
          <a class="dropdown-item" href="<?php echo $PH_BASE_PATH . '?' . $nMode . '/' . $nId; ?>/0/<?php echo $nSubject; ?>">ALL</a>
          <div class="dropdown-divider"></div>
          <?php
          foreach ($aYears as $year) {
            ?>
            <a class="dropdown-item" href="<?php echo $PH_BASE_PATH . '?' . $nMode . '/' . $nId; ?>/<?php echo $year; ?>/<?php echo $nSubject; ?>"><?php echo $year; ?></a>
            <?php
          }
          ?>
        </div>
      </div>
      <div class="dropdown" style=" padding-left: 25px;">
        <a href="#" role="link" id="ThemesMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="color: rgba(0, 0, 0, 0.5);">
          Themes <img width="15" src="<?php echo $PH_BASE_PATH_IMG_ICONS ?>/dropdown_icon.svg">
        </a>
        <div class="dropdown-menu" aria-labelledby="ThemesMenuLink" style="z-index: 99999; ">
          <a class="dropdown-item" href="<?php echo $PH_BASE_PATH . '?' . $nMode . '/' . $nId; ?>/<?php echo $nYear; ?>/0">ALL</a>
          <div class="dropdown-divider"></div>
          <?php
          foreach ($aSubjects as $subj) {
            ?>
            <a class="dropdown-item" href="<?php echo $PH_BASE_PATH . '?' . $nMode . '/' . $nId; ?>/<?php echo $nYear; ?>/<?php echo $subj->Subj_Id; ?>"><?php echo $subj->Subj_Name; ?></a>
            <?php
          }
          ?>
        </div>
      </div>
    </div>
  </div>
  <div class="row mb-4">
    <?php
    foreach ($aArtWorks as $artWork) {
      ?>
      <div class="col-sm-4 col-md-3 mb-5 text-center">
        <a class="" href="<?php echo $PH_BASE_PATH . '?' . '2/' . $artWork->Art_Id; ?>">
          <div class="col-12 d-flex justify-content-center align-items-center" style="height: 250px;">
            <img src="<?php echo $PH_BASE_PATH_IMAGE_SMALL . $artWork->Art_Image ?>" style="max-width: 100%; max-height: 100%;">
          </div>
        </a>
        <div class="mt-3" style="font-style: italic"><?php echo $artWork->Art_Title1; ?></div>
        <div><?php echo $artWork->Art_Title2; ?></div>
        <div><?php echo $artWork->Art_Size; ?><br></div>
      </div>
      <?php
    }
    ?>
  </div>
</div>
