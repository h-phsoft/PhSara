<header style="margin-top: -110px">
  <div id="carouselExampleIndicators" class="carousel slide carousel-fade" data-interval="5000" data-ride="carousel">
    <div class="carousel-inner" role="listbox">
      <?php
      $vActive = 'active';
      foreach ($slider->aSlides as $slide) {
        ?>
        <div class="carousel-item <?php echo $vActive; ?>" style="background-image: url('<?php echo $PH_BASE_PATH_IMAGE_UPLOADS . $slide->Slid_Image; ?>')">
        </div>
        <?php
        $vActive = '';
      }
      ?>
    </div>
  </div>
</header>
