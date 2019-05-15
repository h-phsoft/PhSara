<?php
$exhib = cExhibition::getInstance($nId);
$aHeaders = array();
$nIndex = 0;
if ($exhib->Exhib_Title1 != '') {
  $aHeaders[$nIndex] = 'Information';
  $nIndex++;
}
if (count($exhib->aArtworks) > 0) {
  $aHeaders[$nIndex] = 'Artworks';
  $nIndex++;
}
if (count($exhib->aImages) > 1) {
  $aHeaders[$nIndex] = 'Photos';
  $nIndex++;
}
if (count($exhib->aVideos) > 0) {
  $aHeaders[$nIndex] = 'Videos';
  $nIndex++;
}
?>
<div class="container">
  <div class="row mt-5 text-center">
    <div class="col-12 text-center" style="list-style: none; white-space: nowrap;">
      <?php
      foreach ($aHeaders as $head) {
        ?>
        <a href="<?php echo $PH_BASE_PATH . '?' . '3/' . $nId . '#' . $head; ?>"><?php echo $head; ?></a>&nbsp;&nbsp;&nbsp;
        <?php
      }
      ?>
    </div>
  </div>
</div>
<?php
if ($exhib->Exhib_Title1 != '') {
  $vHeader = 'Information';
  ?>
  <section id="<?php echo $vHeader; ?>" class="pt-2">
    <div class="container">
      <div class="row mt-3 mb-5 text-center border-top">
        <div class="col-12 mt-5 p-0">
          <h3><?php echo $exhib->Exhib_Title1; ?></h3>
        </div>
        <div class="col-12 mb-2 p-0">
          <h5><?php echo $exhib->Exhib_Title2; ?></h5>
        </div>
        <?php
        if ($exhib->Kind_Id == 0) {
          ?>
          <div class="col-12 mb-5 p-0" style="color: #969490;">
            <?php echo date('d F Y', strtotime($exhib->Exhib_From)) . ' - ' . date('d F Y', strtotime($exhib->Exhib_To)); ?>
          </div>
          <?php
        }
        ?>
        <div class="col-12 mb-2 p-3 text-justify exhibition-text">
          <?php echo $exhib->Exhib_Text; ?>
        </div>
      </div>
    </div>
  </section>
  <?php
}
?>
<?php
if (count($exhib->aArtworks) > 0) {
  $vHeader = 'Artworks';
  ?>
  <section id="<?php echo $vHeader; ?>" class="pt-2">
    <div class="row my-5 text-center border-top">
      <div class="col-12 mb-5 p-0 text-center">
        <h5 style="margin-top: -15px;">
          <span style="background-color: #fafafa;">&nbsp;&nbsp;&nbsp;<?php echo $vHeader; ?>&nbsp;&nbsp;&nbsp;</span>
        </h5>
      </div>
      <?php
      if (count($exhib->aArtworks) > 1) {
        ?>
        <div class="container-fluid p-0 text-center variable slider">
          <?php
          foreach ($exhib->aArtworks as $artWork) {
            ?>
            <a href="<?php echo $PH_BASE_PATH . '?' . '2/' . $artWork->Art_Id; ?>" class="image_popup" rel="group">
              <div class="col-12 d-flex justify-content-center align-items-center" style="height: 50vh;">
                <img src="<?php echo $PH_BASE_PATH_IMAGE_SMALL . $artWork->Art_Image ?>" style="max-height: 50vh; max-width: 98vw">
              </div>
            </a>
            <?php
          }
          ?>
          <?php
        } else {
          ?>
          <div class="container-fluid p-0 text-center">
            <?php
            foreach ($exhib->aArtworks as $artWork) {
              ?>
              <a href="<?php echo $PH_BASE_PATH . '2/' . $artWork->Art_Id; ?>" class="image_popup" rel="group">
                <div class="col-12 d-flex justify-content-center align-items-center" style="height: 50vh;">
                  <img src="<?php echo $PH_BASE_PATH_IMAGE_SMALL . $artWork->Art_Image ?>" style="max-height: 50vh; max-width: 98vw">
                </div>
              </a>
              <?php
            }
            ?>
          </div>
          <?php
        }
        ?>
      </div>
    </div>
  </section>
  <?php
}
?>
<?php
if (count($exhib->aImages) > 0) {
  $vHeader = 'Photos';
  ?>
  <section id="<?php echo $vHeader; ?>" class="pt-2">
    <div class="row my-5 text-center border-top">
      <div class="col-12 mb-5 p-0 text-center">
        <h5 style="margin-top: -15px;">
          <span style="background-color: #fafafa;">&nbsp;&nbsp;&nbsp;<?php echo $vHeader; ?>&nbsp;&nbsp;&nbsp;</span>
        </h5>
      </div>
      <?php
      if (count($exhib->aImages) > 1) {
        ?>
        <div class="container-fluid p-0 variable slider">
          <?php
          foreach ($exhib->aImages as $image) {
            ?>
            <div class="col-12 d-flex justify-content-center align-items-center" style="height: 50vh;">
              <img src="<?php echo $PH_BASE_PATH_IMAGE_UPLOADS . $image->Exhib_Image ?>" style="max-height: 50vh; max-width: 50vw">
            </div>
            <?php
          }
          ?>
        </div>
        <?php
      } else {
        ?>
        <div class="container-fluid p-0 text-center">
          <?php
          foreach ($exhib->aImages as $image) {
            ?>
            <div class="col-12 d-flex justify-content-center align-items-center" style="height: 50vh;">
              <img src="<?php echo $PH_BASE_PATH_IMAGE_UPLOADS . $image->Exhib_Image ?>" style="max-height: 50vh; max-width: 50vw">
            </div>
            <?php
          }
          ?>
        </div>
        <?php
      }
      ?>
    </div>
  </section>
  <?php
}
?>
<?php
if (count($exhib->aVideos) > 0) {
  $vHeader = 'Videos';
  ?>
  <section id="<?php echo $vHeader; ?>" class="pt-2">
    <div class="container">
      <div class="row my-5 text-center border-top">
        <div class="col-12 mb-5 p-0 text-center">
          <h5 style="margin-top: -15px;">
            <span style="background-color: #fafafa;">&nbsp;&nbsp;&nbsp;<?php echo $vHeader; ?>&nbsp;&nbsp;&nbsp;</span>
          </h5>
        </div>
        <div class="col-12 p-0 text-center">
          <?php
          foreach ($exhib->aVideos as $video) {
            ?>
            <div class="row text-center">
              <div class="col-12">
                <div class="col-12 col-md-6 p-0">
                  <iframe class="vid" width="100%" height="280" src="<?php echo $video->Video_URL; ?>" frameborder="0" webkitallowfullscreen="" mozallowfullscreen="" allowfullscreen="" id="fitvid810909"></iframe>
                </div>
                <div class="col-12 col-md-6 p-0">
                </div>
              </div>
            </div>
            <div class="row text-center">
              <div class="col-12 col-md-6 p-0">
                <div class="col-12 p-0">
                  <h5><?php echo $video->Video_Title1; ?></h5>
                </div>
                <div class="col-12 p-0">
                  <?php echo $video->Video_Title2; ?>
                  <br>
                  <?php echo $video->Video_Text; ?>
                </div>
              </div>
              <div class="col-12 col-md-6 p-0">
              </div>
            </div>
            <?php
          }
          ?>
        </div>
      </div>
    </div>
  </section>
  <?php
}
