<!-- Navigation -->
<nav class="navbar navbar-expand-lg navbar-light">
  <div class="container-fluid">
    <a class="navbar-brand mr-0" href="<?php echo $PH_BASE_PATH; ?>">
      <img src="<?php echo $PH_BASE_PATH_IMG_LOGO; ?>logo.png" alt="<?php echo $ph_Setting_SiteName; ?>" style="width: 90%;">
    </a>
    <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarResponsive">
      <ul class="navbar-nav ml-auto text-center">
        <?php
        foreach ($mainMenu->aSubs as $menu) {
          $vActive = '';
          if ($nMode === $menu->Menu_Id) {
            $vActive = ' active';
          }
          ?>
          <li class="nav-item<?php echo $vActive; ?>">
            <a class="nav-link" href="<?php echo $PH_BASE_PATH . '?' . ($menu->Menu_URL == '' ? $menu->Menu_Id : $menu->Menu_URL); ?>"><?php echo $menu->Menu_Name; ?></a>
          </li>
          <?php
        }
        ?>
      </ul>
    </div>
  </div>
</nav>
