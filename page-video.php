<?php
$aVideos = cVideo::getArray();
?>
<div class="container">
  <div class="row my-5 text-center">
    <div class="col-12">
      <h4><?php echo $cMenu->Menu_Name; ?></h4>
    </div>
  </div>
  <?php
  foreach ($aVideos as $video) {
    ?>
    <div class="row mb-5">
      <div class="col-12">
        <div class="row p-3">
          <div class="col-12">
            <h5><?php echo $video->Video_Title1; ?></h5>
          </div>
        </div>
        <div class="row">
          <div class="col-12 col-md-6 p-0">
            <iframe class="vid" width="100%" height="280" src="<?php echo $video->Video_URL; ?>" frameborder="0" webkitallowfullscreen="" mozallowfullscreen="" allowfullscreen="" id="fitvid810909"></iframe>
          </div>
          <div class="col-12 col-md-6">
            <?php echo date('F Y', strtotime($video->Video_Date)); ?>
            <br>
            <?php echo $video->Video_Text; ?>
            <br>
          </div>
        </div>
      </div>
    </div>
    <?php
  }
  ?>
</div>
