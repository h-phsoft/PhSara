<?php
$page = cPage::getInstance(1);
?>
<div class="container">
  <div class="row my-5 text-center">
    <div class="col-12">
      <h4><?php echo $cMenu->Menu_Name; ?></h4>
    </div>
  </div>
  <div class="row mb-4 px-0">
    <div class="col-md-6 d-block d-md-none">
      <?php
      foreach ($page->aImages as $pImage) {
        ?>
        <img src="<?php echo $PH_BASE_PATH_IMAGE_UPLOADS . $pImage->Page_Image; ?>" alt="" style="width: 100%">
        <?php
      }
      ?>
    </div>
    <div class="col-md-6 p-3 text-justify">
      <?php echo $page->Page_Text; ?>
    </div>
    <div class="col-md-6 d-none d-md-block">
      <?php
      foreach ($page->aImages as $pImage) {
        ?>
        <img src="<?php echo $PH_BASE_PATH_IMAGE_UPLOADS . $pImage->Page_Image; ?>" alt="" style="width: 100%">
        <?php
      }
      ?>
    </div>
  </div>
</div>
