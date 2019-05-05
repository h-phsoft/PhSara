<?php
if ($nId == -1) {
  $nId = 1;
}
$aExhibitions = cExhibition::getArray('`kind_id` IN (0,3) AND `type_id`=' . $nId);
$aExhibitionTypes = cExhibitionType::getArray();
?>
<div class="container">
  <div class="row my-5 text-center">
    <div class="col-12">
      <h4><?php echo $cMenu->Menu_Name; ?></h4>
    </div>
    <div class="col-12">
      <div class="row text-sm-center text-sm-center" style="list-style: none; white-space: nowrap;">
        <?php
        $nIdx = 0;
        foreach ($aExhibitionTypes as $type) {
          $vColor = 'rgba(0, 0, 0, 0.5);';
          if ($nId === $type->Type_Id) {
            $vColor = 'rgba(0, 0, 0, 1);';
          }
          $nIdx = 2 - $nIdx;
          $vAlign = 'right';
          if ($nIdx === 0) {
            $vAlign = 'left';
          }
          ?>
          <li class="nav-item<?php echo $vActive; ?> text-xs-center text-sm-<?php echo $vAlign; ?>" style="width: 50%">
            <a class="nav-link" href="<?php echo $PH_BASE_PATH . '?' . $nMode . '/' . $type->Type_Id; ?>" style="color: <?php echo $vColor; ?>"><?php echo $type->Type_Name; ?></a>
          </li>
          <?php
        }
        ?>
      </div>
    </div>
  </div>
  <div class="row mb-4">
    <?php
    foreach ($aExhibitions as $exhib) {
      ?>
      <div class="col-sm-4 mb-5 text-center">
        <a href="<?php echo $PH_BASE_PATH . '?' . '3/' . $exhib->Exhib_Id; ?>">
          <div class="col-12 mb-3 d-flex justify-content-center align-items-center" style="height: 300px;">
            <img src="<?php echo $PH_BASE_PATH_IMAGE_UPLOADS . $exhib->Exhib_Image ?>" style="max-width: 100%; max-height: 100%;">
          </div>
        </a>
        <div class="col-12 mb-2 p-0"><h5><?php echo $exhib->Exhib_Title1; ?></h5></div>
        <div class="col-12 mb-2 p-0"><?php echo $exhib->Exhib_Title2; ?></div>
        <?php
        if ($exhib->Exhib_From != '' && $exhib->Exhib_To != '') {
          ?>
          <div class="col-12 mb-2 p-0"><?php echo date('d F Y', strtotime($exhib->Exhib_From)) . ' - ' . date('d F Y', strtotime($exhib->Exhib_To)); ?></div>
          <?php
        }
        ?>
      </div>
      <?php
    }
    ?>
  </div>
</div>
