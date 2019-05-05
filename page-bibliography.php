<?php
if ($nId == -1) {
  $nId = 1;
}
$aPublications = cPublication::getArray('`bibl_id`=' . $nId);
$aBibliographies = cBibliography::getArray();
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
        foreach ($aBibliographies as $bibl) {
          $vColor = 'rgba(0, 0, 0, 0.5);';
          if ($nId === $bibl->Bibl_Id) {
            $vColor = 'rgba(0, 0, 0, 1);';
          }
          $nIdx = 2 - $nIdx;
          $vAlign = 'right';
          if ($nIdx === 0) {
            $vAlign = 'left';
          }
          ?>
          <li class="nav-item<?php echo $vActive; ?> text-xs-center text-sm-<?php echo $vAlign; ?>" style="width: 50%">
            <a class="nav-link" href="<?php echo $PH_BASE_PATH . '?' . $nMode . '/' . $bibl->Bibl_Id; ?>" style="color: <?php echo $vColor; ?>"><?php echo $bibl->Bibl_Title1; ?></a>
          </li>
          <?php
        }
        ?>
      </div>
    </div>
  </div>
  <div class="row mb-4">
    <?php
    if ($nId == 1) {
      foreach ($aPublications as $pub) {
        ?>
        <div class="col-sm-4 col-md-3 mb-5 text-center">
          <div class="col-12 mb-3 d-flex justify-content-center align-items-center" style="height: 300px;">
            <img class="" src="<?php echo $PH_BASE_PATH_IMAGE_UPLOADS . $pub->Pub_Image ?>" style="max-width: 100%; max-height: 100%;">
          </div>
          <div class="col-12 mb-2 p-0"><h5><?php echo $pub->Pub_Title1; ?></h5></div>
          <div class="col-12 mb-2 p-0"><?php echo $pub->Pub_Title2; ?></div>
          <div class="col-12 mb-2 p-0"><?php echo $pub->Pub_Publisher; ?></div>
          <div class="col-12 mb-2 p-0"><?php echo $pub->Pub_Dimensions; ?></div>
        </div>
        <?php
      }
    } else {
      ?>
      <div class="col-md-6 d-block d-md-none">
        <div class="row mb-4">
          <?php
          foreach ($aPublications as $pub) {
            ?>
            <div class="col-sm-6 mb-5 text-center">
              <div class="col-12 mb-3 p-0">
                <img src="<?php echo $PH_BASE_PATH_IMAGE_UPLOADS . $pub->Pub_Image ?>" style="width: 100%; height: 100%;">
              </div>
              <div class="col-12 mb-2 p-0"><h5><?php echo $pub->Pub_Title1; ?></h5></div>
            </div>
            <?php
          }
          ?>
        </div>
      </div>
      <div class="col-md-6 text-justify">
        <?php
        foreach ($aBibliographies as $bibl) {
          if ($nId === $bibl->Bibl_Id) {
            ?>
            <?php echo $bibl->Bibl_Title1; ?>
            <?php echo $bibl->Bibl_Text; ?>
            <?php
          }
        }
        ?>
      </div>
      <div class="col-md-6 d-none d-md-block">
        <div class="row mb-4">
          <?php
          foreach ($aPublications as $pub) {
            ?>
            <div class="col-sm-6 mb-5 text-center">
              <div class="col-12 mb-3 p-0">
                <img src="<?php echo $PH_BASE_PATH_IMAGE_UPLOADS . $pub->Pub_Image ?>" style="width: 100%; height: 100%;">
              </div>
              <div class="col-12 mb-2 p-0"><h5><?php echo $pub->Pub_Title1; ?></h5></div>
            </div>
            <?php
          }
          ?>
        </div>
      </div>
      <?php
    }
    ?>
  </div>
</div>
