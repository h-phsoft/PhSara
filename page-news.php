<?php
$aExhibitions = cExhibition::getArray('`kind_id` IN (2,3)');
?>
<div class="container">
  <div class="row my-5 text-center">
    <div class="col-12">
      <h4><?php echo $cMenu->Menu_Name; ?></h4>
    </div>
  </div>
  <div class="row mb-4">
    <?php
    foreach ($aExhibitions as $exhib) {
      ?>
      <div class="col-sm-4 mb-5 text-center">
        <div class="col-12 mb-2 p-0">
          <?php echo date('d F Y', strtotime($exhib->Exhib_Date)); ?>
        </div>
        <a href="<?php echo $PH_BASE_PATH . '?' . '3/' . $exhib->Exhib_Id; ?>">
          <div class="col-12 mb-3 d-flex justify-content-center align-items-center" style="height: 300px;">
            <img src="<?php echo $PH_BASE_PATH_IMAGE_UPLOADS . $exhib->Exhib_Image ?>" style="max-width: 100%; max-height: 100%;">
          </div>
        </a>
        <div class="col-12 mb-2 p-0">
          <h6 style="line-height: 1.5;"><?php echo $exhib->Exhib_Title1; ?></h6>
        </div>
        <div class="col-12 mb-2 p-0">
          <?php echo $exhib->Exhib_Title2; ?>
        </div>
        <!--<div class="col-12 mb-2 p-0">
        <?php echo date('d F Y', strtotime($exhib->Exhib_From)) . ' - ' . date('d F Y', strtotime($exhib->Exhib_To)); ?>
        </div>-->
      </div>
      <?php
    }
    ?>
  </div>
</div>
