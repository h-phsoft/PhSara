<?php
$artWork = cArtWork::getInstance($nId);
?>
<div class="container">
  <div class="row mt-5 text-center">
    <div class="col-12">
      <div class="dropdown ">
        <a href="#" role="link" id="ThemesMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <img width="15" src="<?php echo $PH_BASE_PATH_IMG_ICONS ?>/dropdown_icon.svg"> Share
        </a>
        <div id="social_sharing_links" class="dropdown-menu" aria-labelledby="ThemesMenuLink" style="z-index: 99999;">
          <a class="dropdown-item" target="_BLANK" href="https://www.facebook.com/sharer/sharer.php?u=<?php echo $PH_SHARE_PATH_IMAGE_SMALL . $artWork->Art_Image ?>"><i class="fab fa-facebook"></i>  Facebook</a>
          <a class="dropdown-item" target="_BLANK" href="mailto:?subject=Sara Shamma,<?php echo $artWork->Art_Title1; ?>&amp;body=take a look please: <?php echo $PH_SHARE_URL . $artWork->Art_Id; ?>"><i class="far fa-envelope"></i>  Email</a>
          <a class="dropdown-item" target="_BLANK" href="http://www.pinterest.com/pin/create/button/?description=Sara Shamma,<?php echo $artWork->Art_Title1; ?>&AMP;url=<?php echo $PH_SHARE_URL . $artWork->Art_Id; ?>&AMP;media=<?php echo $PH_SHARE_PATH_IMAGE_SMALL . $artWork->Art_Image ?>"><i class="fab fa-pinterest"></i>  Pinterest</a>
          <a class="dropdown-item" target="_BLANK" href="https://twitter.com/intent/tweet?text=Sara Shamma,<?php echo $artWork->Art_Title1; ?>&AMP;url=<?php echo $PH_SHARE_URL . $artWork->Art_Id; ?>"><i class="fab fa-twitter"></i>  Twitter</a>
          <!--<a class="dropdown-item" target="_BLANK"><i class="fab fa-instagram"></i>  Instagram</a>-->
        </div>
      </div>
    </div>
  </div>
  <section id="artworks">
    <div class="row mb-5 text-center">
      <div class="col-12 my-2 text-center">
        <div class="powerzoomFrame">
          <a href="<?php echo $PH_BASE_PATH_IMAGE_SMALL . $artWork->Art_Image ?>" data-fancybox>
            <img id="artWork" src="<?php echo $PH_BASE_PATH_IMAGE_SMALL . $artWork->Art_Image ?>" />
          </a>
        </div>
      </div>
      <div class="col-12 my-3 text-center">
        <div><?php echo $artWork->Art_Title1; ?></div>
        <div><?php echo $artWork->Art_Title2; ?></div>
        <div><?php echo $artWork->Art_Size; ?></div>
      </div>
    </div>
  </section>
</div>
